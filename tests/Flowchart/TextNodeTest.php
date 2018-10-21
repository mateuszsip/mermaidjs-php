<?php
declare(strict_types=1);

namespace Sip\MermaidJsPhp\Tests\Flowchart;

use Sip\MermaidJsPhp\Flowchart\FlowchartNode;
use Sip\MermaidJsPhp\Flowchart\IdentifiableNode;
use Sip\MermaidJsPhp\Flowchart\TextNode;
use Sip\MermaidJsPhp\Flowchart\TransitionWithoutText;
use Sip\MermaidJsPhp\Transitions;

class TextNodeTest extends FlowchartNodeTest
{
    public function testContractWithTransitions(): void
    {
        $transitions = Transitions::end();

        $node = $this->createNodeWithTransitions('foo', 'bar', $transitions);

        $this->assertSame('foo', $node->getId());
        $this->assertSame('bar', $node->getContent());
        $this->assertSame($transitions, $node->next());
    }

    public function testContractWithoutTransitions(): void
    {
        $node = $this->createNodeWithoutTransitions('foo', 'bar');

        $this->assertSame('foo', $node->getId());
        $this->assertSame('bar', $node->getContent());
        $this->assertFalse($node->next()->notEmpty());
    }

    public function describingExamples(): iterable
    {
        yield 'with transition' => [
            $this->createNodeWithTransitions('foo', 'bar', Transitions::fromArray([
                new TransitionWithoutText(
                    IdentifiableNode::withoutTransitions('baz')
                )
            ])),
            'foo[bar] --> baz'
        ];

        yield 'without transitions' => [
            $this->createNodeWithoutTransitions('foo', 'bar'),
            'foo[bar]'
        ];
    }

    protected function createNodeWithTransitions(string $id, ?string $content, Transitions $next): FlowchartNode
    {
        return TextNode::withTransitions($id, $content, $next);
    }

    protected function createNodeWithoutTransitions(string $id, ?string $content): FlowchartNode
    {
        return TextNode::withoutTransitions($id, $content);
    }
}