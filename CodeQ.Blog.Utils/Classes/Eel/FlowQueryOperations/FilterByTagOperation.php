<?php
namespace CodeQ\Blog\Utils\Eel\FlowQueryOperations;

use Neos\Flow\Annotations as Flow;
use Neos\Eel\FlowQuery\FlowQuery;
use Neos\Eel\FlowQuery\Operations\AbstractOperation;
use Neos\ContentRepository\Domain\Model\Node;

class FilterByTagOperation extends AbstractOperation {

    /**
     * {@inheritdoc}
     *
     * @var string
     */
    static protected $shortName = 'filterByTag';

    /**
     * {@inheritdoc}
     *
     * @param FlowQuery $flowQuery the FlowQuery object
     * @param array $arguments the arguments for this operation
     * @throws \Neos\Eel\FlowQuery\FlowQueryException
     * @return void
     */
    public function evaluate(FlowQuery $flowQuery, array $arguments) {
        $nodes = $flowQuery->getContext();

        // Check sort property
        if (!isset($arguments[0]) || empty($arguments[0])) {
            throw new \Neos\Eel\FlowQuery\FlowQueryException('Please provide a tag uriPathSegment to filter by.', 1467881104);
        }
        $requiredTagName = $arguments[0];

        $filteredNodes = array_filter($nodes, function($node) use ($requiredTagName) {
            /** @var Node $node */
            $tags = $node->getProperty('tags');

            if (!isset($tags) || empty($tags)) {
                return false;
            }

            // search through all tags and see if they match
            return array_reduce($tags, function($carry, $item) use ($requiredTagName) {
                /** @var Node $item */
                return $item->getProperty('uriPathSegment') === $requiredTagName ? true : $carry;
            });
        });

        $flowQuery->setContext($filteredNodes);
    }
}
