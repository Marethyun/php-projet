<?php


namespace model\mappers;


use model\entities\Entity;
use model\entities\Message;
use model\entities\MessageFragment;
use model\entities\Thread;
use model\ResultSet;

final class JoinedThreadsMapper extends Mapper {

    /**
     * @var FilteredMapper
     */
    private $threadsMapper;

    /**
     * @var FilteredMapper
     */
    private $messagesMapper;

    /**
     * @var FilteredMapper
     */
    private $fragmentsMapper;


    /**
     * JoinedThreadsMapper constructor.
     * @param array $threadsFilter
     * @param array $messagesFilter
     * @param array $fragmentsFilter
     */
    public function __construct(array $threadsFilter, array $messagesFilter, array $fragmentsFilter) {
        $this->threadsMapper = new FilteredMapper(Thread::class, $threadsFilter);
        $this->messagesMapper = new FilteredMapper(Message::class, $messagesFilter);
        $this->fragmentsMapper = new FilteredMapper(MessageFragment::class, $fragmentsFilter);
    }

    // TODO Link threads, messages and fragments together
    public function map(ResultSet $resultSet) {

        $threads = array();

        foreach ($resultSet->getRows() as $row) {
            $returned = $this->mapRow($row);

            $thread = $returned['thread'];
            $message = $returned['message'];
            $fragment = $returned['fragment'];

            // Search for the thread
            $tk = $this->getKeyIfExistsById($threads, $thread->id);

            if (is_null($tk)) {
                // If it does not exists, add it with message and fragment
                $message->fragments = array($fragment);
                $thread->messages = array($message);
                array_push($threads, $thread);
            } else {
                // If it does exists, get it
                $thread = $threads[$tk];

                if (is_null($thread->messages)) {
                    // If it hasn't messages, add a message with its fragment
                    $message->fragments = array($fragment);
                    $thread->messages = array($message);
                } else {
                    // If it has messages, search for it
                    $mk = $this->getKeyIfExistsById($thread->messages, $message->id);

                    if (is_null($mk)) {
                        // If the message does not exists, add it with its fragment
                        $message->fragments = array($fragment);
                        array_push($thread->messages, $message);
                    } else {
                        // If the message exists
                    }

                }

            }

        }

    }

    /**
     * @param array $row
     * @return array
     */
    protected function mapRow(array $row) {
        $thread = $this->threadsMapper->mapRow($row);
        $message = $this->messagesMapper->mapRow($row);
        $fragment = $this->fragmentsMapper->mapRow($row);

        // That's an ugly way to return multiple parameters but that's PHP so it's OK
        // (nobody should notice that I violated this function's contract)
        return array(
            'thread' => $thread,
            'message' => $message,
            'fragment' => $fragment
        );
    }

    /**
     * Elements: an array of objects with the attribute 'id'
     * @param array $elements
     * @param int $id
     * @return int|null
     */
    private function getKeyIfExistsById(array $elements, int $id) {
        if (is_null($elements)) return null;

        foreach ($elements as $key => $element) {
            if ($element->id == $id) return $key;
        }

        return null;
    }
}