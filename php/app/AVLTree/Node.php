<?php

namespace App\AVLTree;

class Node
{
    public int $value;
    public Node | null $left;
    public Node | null $right;
    public int $height;

    public function __construct($value, Node $left = NULL, Node $right = NULL, $height = 1)
    {
        $this->value = $value;
        $this->left = $left;
        $this->right = $right;
        $this->height = $height;
    }
}
