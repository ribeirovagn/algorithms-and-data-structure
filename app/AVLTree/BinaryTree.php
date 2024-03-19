<?php

namespace App\AVLTree;

use App\AVLTRee\Node;

class BinaryTree
{

    public function getValue(Node | null $node)
    {
        return $node->value;
    }


    // Recursivo
    public function preOrder(Node | null $node): string
    {
        $output[] = $this->getValue($node);

        if ($node->left) {
            $output[] = $this->preOrder($node->left);
        }

        if ($node->right) {
            $output[] = $this->preOrder($node->right);
        }

        return implode(', ', $output);
    }

    // Recursivo
    public function postOrder(Node | null $node): string
    {
        if ($node->left) {
            $output[] = $this->postOrder($node->left);
        }

        if ($node->right) {
            $output[] = $this->postOrder($node->right);
        }

        $output[] = $this->getValue($node);

        return implode(', ', $output);
    }

    // Recursivo
    public function inOrder(Node $node): string
    {

        if ($node->left) {
            $output[] = $this->inOrder($node->left);
        }

        $output[] = $this->getValue($node);

        if ($node->right) {
            $output[] = $this->inOrder($node->right);
        }

        return implode(', ', $output);
    }

    /**
     * 
     * Esse algoritmo não é aplicado de forma linear. 
     * Ele vai nível por nível e, portanto, também é chamado de LevelOrder. 
     * Este algoritmo geralmente é usado quando a profundidade de uma árvore é desconhecida ou mesmo dinâmica.
     */
    public function levelOrder(Node $queue, array $output = []): string
    {
        if ($queue) {
            $node = $queue;

            $output[] = $this->getValue($node);

            if ($node->left) {
                $queue = $node->left;
            }

            if ($node->right) {
                $queue = $node->right;
            }

            return $this->levelOrder($queue, $output);
        }
        return implode(', ', $output);
    }
}
