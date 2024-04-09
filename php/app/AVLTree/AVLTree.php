<?php

declare(strict_types=1);

namespace App\AVLTree;

use App\AVLTree\Node;

class AVLTree extends BinaryTree
{

    public function search(Node | null $node, int $value): Node | null
    {
        if (!$node instanceof Node) {
            return null;
        }

        if ($node->value === $value) {
            return $node;
        }

        if ($value < $node->value  && $node instanceof Node) {
            return $this->search($node->left, $value);
        }

        if ($value > $node->value && $node instanceof Node) {
            return $this->search($node->right, $value);
        }

        return null;
    }


    public function insert(Node | null $root, int $value): Node
    {
        if (is_null($root)) {
            return new Node($value);
        }

        if ($value < $root->value) {
            $newNodeLeft = $this->insert($root->left, $value);
            return $this->rebalance(
                $this->leftReplace(
                    $root,
                    $newNodeLeft,
                    max($this->getHeight($newNodeLeft), $this->getHeight($root->right)) + 1
                )
            );
        }

        $newNodeRight = $this->insert($root->right, $value);
        return $this->rebalance(
            $this->rightReplace(
                $root,
                $newNodeRight,
                max($this->getHeight($root->left), $this->getHeight($newNodeRight)) + 1
            )
        );
    }

    public function delete(Node | null $root, $value): Node | null
    {

        if ($value === $root->value) {
            // Cenario 1
            // O Node não tem filhos
            if (
                !$root->left instanceof Node && !$root->right instanceof Node
            ) {
                $root = null;
                return $root;
            }

            // Cenario 2
            // O Node não tem filhos na esquerda
            else if (
                !$root->left instanceof Node && $root->right instanceof Node
            ) {
                $temp = $root->right;
                $root = $temp;
                return $root;
            }

            // Cenario 3
            // O Node não tem filhos na direita
            else if (
                $root->left instanceof Node && !$root->right instanceof Node
            ) {
                $temp = $root->left;
                $root = $temp;
                return $root;
            }

            // Cenario 4
            // O Node tem os dois filhos
            else {

                $minRightSubtree = null;
                $current = $root->right;

                while ($current->left instanceof Node) {
                    $current = $current->left;
                }

                $minRightSubtree = $current;
                $root->value = $minRightSubtree->value;
                $root->right = $this->delete($root->right, $current->value);
            }
        } else if ($value < $root->value) {
            $root->left = $this->delete($root->left, $value);
        } else if ($value > $root->value) {
            $root->right = $this->delete($root->right, $value);
        }

        // Precisa rebalancear?
        $balanceFactor = $this->balanceFactor($root);

        if ($balanceFactor != -1 && $balanceFactor != 0 && $balanceFactor != 1) {
            $root = $this->rebalance($root);
        }


        return $root;
    }


    protected function getHeight(Node $node = null)
    {
        return $node ? $node->height : 0;
    }

    private function rebalance(Node $node)
    {
        $balanceFactor = $this->balanceFactor($node);
        $balanceFactorLeft = $node->left ? $this->balanceFactor($node->left) : 0;
        $balanceFactorRight = $node->right ? $this->balanceFactor($node->right) : 0;

        if ($balanceFactor === 2) {
            if ($balanceFactorLeft === -1) {
                $node = $this->leftReplace($node, $this->leftRotate($node->left));
                return $this->rightRotate($node);
            }
            if ($balanceFactorLeft === 1) {
                return $this->rightRotate($node);
            }
        }

        if ($balanceFactor === -2) {
            if ($balanceFactorRight === 1) {
                $node = $this->rightReplace($node, $this->rightRotate($node->right));
            }

            if ($balanceFactorRight === -1) {
                return $this->leftRotate($node);
            }
        }

        return $node;
    }

    public function leftRotate(Node $node)
    {
        $left = $node->left;
        $rl = $node->right->left;
        $rr = $node->right->right;

        $height = max($this->getHeight($left), $this->getHeight($rl)) + 1;

        return new Node(
            $node->right->value,
            new Node($node->value, $left, $rl, $height),
            $rr,
            max($height, $this->getHeight($rr) + 1)
        );
    }

    public function rightRotate($node)
    {
        $ll = $node->left->left;
        $lr = $node->left->right;
        $right = $node->right;

        $height = max($this->getHeight($lr), $this->getHeight($right)) + 1;

        return new Node(
            $node->left->value,
            $ll,
            new Node($node->value, $lr, $right, $height),
            max($height, $this->getHeight($ll)) + 1
        );
    }

    protected function leftReplace(Node $node, Node $newNodeLeft = null, $height = null): Node
    {
        return new Node($node->value, $newNodeLeft, $node->right, $height ?: $node->height);
    }

    protected function rightReplace(Node $node, Node $newNodeRight = null, $height = null): Node
    {
        return new Node($node->value, $node->left, $newNodeRight, $height ?: $node->height);
    }

    protected function balanceFactor(Node $node)
    {
        return $this->getHeight($node->left) - $this->getHeight($node->right);
    }
}
