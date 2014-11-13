<?php

namespace Saxulum\JsonDocument;

class ObjectNode extends AbstractParent
{
    /**
     * @var AttributeNode[]
     */
    protected $attributes = array();

    /**
     * @param AttributeNode $attribute
     */
    public function addAttribute(AttributeNode $attribute)
    {
        $name = $attribute->getName();
        if (isset($this->attributes[$name])) {
            throw new \InvalidArgumentException(sprintf("There is allready a attribute with this name '%s'!", $name));
        }

        $this->checkNode($attribute);
        Document::setProperty($attribute, 'parent', $this);
        $this->attributes[$attribute->getName()] = $attribute;
    }

    /**
     * @param AttributeNode $attribute
     * @throw \InvalidArgumentException
     */
    public function removeAttribute(AttributeNode $attribute)
    {
        $name = $attribute->getName();
        if (!isset($this->attributes[$name])) {
            throw new \InvalidArgumentException("Unknown node!");
        }

        Document::setProperty($attribute, 'parent', null);
    }

    /**
     * @return AttributeNode[]
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param $name
     * @return AttributeNode|null
     */
    public function getAttribute($name)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    /**
     * @param AbstractElement $node
     */
    public function addNode(AbstractElement $node)
    {
        $name = $node->getName();
        if (isset($this->nodes[$name])) {
            throw new \InvalidArgumentException("There is allready a node with this name!");
        }

        $this->checkNode($node);
        Document::setProperty($node, 'parent', $this);
        $this->nodes[$node->getName()] = $node;
    }

    /**
     * @param AbstractElement $node
     */
    public function removeNode(AbstractElement $node)
    {
        $name = $node->getName();
        if (!isset($this->nodes[$name])) {
            throw new \InvalidArgumentException("Unknown node!");
        }

        Document::setProperty($node, 'parent', null);
    }
}
