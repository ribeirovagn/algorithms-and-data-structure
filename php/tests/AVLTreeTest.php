<?php

declare(strict_types=1);

namespace Tests;

use App\AVLTree\AVLTree;
use App\AVLTree\Node;
use PHPUnit\Framework\TestCase;

class AVLTreeTest extends TestCase
{

    protected $avlTree;
    protected $root;


    protected function initTree()
    {
        $this->avlTree = new AVLTree();
        $this->root = new Node(4);
        $this->root = $this->avlTree->insert($this->root, 2);
        $this->root = $this->avlTree->insert($this->root, 1);
        $this->root = $this->avlTree->insert($this->root, 3);
        $this->root = $this->avlTree->insert($this->root, 6);
        $this->root = $this->avlTree->insert($this->root, 5);
        $this->root = $this->avlTree->insert($this->root, 7);
        $this->root = $this->avlTree->insert($this->root, 8);
    }


    public function testHeight()
    {
        $this->initTree();

        $this->assertSame($this->root->height, 4, "O Node raiz deve ter a altura 4");
        $this->assertSame($this->root->left->height, 2, "A altura do nó esquerdo deve ser 2");
        $this->assertSame($this->root->right->height, 3, "A altura do nó esquerdo deve ser 3");
    }

    public function testSearch()
    {

        $this->initTree();
        $searchFirstValue = 4;
        $search = $this->avlTree->search($this->root, $searchFirstValue);
        $this->assertSame($searchFirstValue, $search->value, "Deve retornar nó raiz");

        $searchLeftValue = 2;
        $searchLeft = $this->avlTree->search($this->root, $searchLeftValue);
        $this->assertSame($searchLeftValue, $searchLeft->value, "Deve encontrar um nó na esquerda");

        $searchRightValue = 8;
        $searchRight = $this->avlTree->search($this->root, $searchRightValue);
        $this->assertSame($searchRightValue, $searchRight->value, "Deve encontrar um nó na direita");

        $searchNullValue = 81;
        $searchNull = $this->avlTree->search($this->root, $searchNullValue);
        $this->assertNull($searchNull, "Não deve encontrar valores");
    }

    // Cenario 1
    // O root não tem filhos
    public function testDeleteScenario1()
    {
        $this->initTree();

        $scenario1 = 8;
        $newNode = $this->avlTree->delete($this->root, $scenario1);

        // Caso o valor procurado não seja encontrado retorna NULL
        $searchNodeDeleted = $this->avlTree->search($newNode, $scenario1);
        $this->assertNull($searchNodeDeleted, "Cenario 1: Deletar um Node sem filhos");

        $inOrder = $this->avlTree->inOrder($newNode);
        $this->assertSame($inOrder, "1, 2, 3, 4, 5, 6, 7", "Deve retornar uma lista de valores InOrder sem o valor deletado");
    }

    // Cenario 2
    // O root não tem filhos na esquerda
    public function testDeleteScenario2()
    {
        $this->initTree();

        $scenario1 = 7;
        $newNode = $this->avlTree->delete($this->root, $scenario1);

        // Caso o valor procurado não seja encontrado retorna NULL
        $searchNodeDeleted = $this->avlTree->search($newNode, $scenario1);
        $this->assertNull($searchNodeDeleted, "Cenario 1: Deletar um Node sem filhos na direita");

        $inOrder = $this->avlTree->inOrder($newNode);
        $this->assertSame($inOrder, "1, 2, 3, 4, 5, 6, 8", "Deve retornar uma lista de valores InOrder sem o valor deletado");
    }

    // Cenario 3
    // O root não tem filhos na direita
    public function testDeleteScenario3()
    {
        $this->initTree();
        $this->root = $this->avlTree->insert($this->root, 0);

        $scenario3 = 1;
        $newNode = $this->avlTree->delete($this->root, $scenario3);

        // Caso o valor procurado não seja encontrado retorna NULL
        $searchNodeDeleted = $this->avlTree->search($newNode, $scenario3);
        $this->assertNull($searchNodeDeleted, "Cenario 1: Deletar um Node sem filhos na direita");

        $inOrder = $this->avlTree->inOrder($newNode);
        $this->assertSame($inOrder, "0, 2, 3, 4, 5, 6, 7, 8", "Deve retornar uma lista de valores InOrder sem o valor deletado");
    }

    // Cenario 4
    // O root tem filhos em ambos os lados
    public function testDeleteScenario4()
    {
        $this->initTree();
        $this->root = $this->avlTree->insert($this->root, 0);

        $scenario3 = 6;
        $newNode = $this->avlTree->delete($this->root, $scenario3);

        // Caso o valor procurado não seja encontrado retorna NULL
        $searchNodeDeleted = $this->avlTree->search($newNode, $scenario3);
        $this->assertNull($searchNodeDeleted, "Cenario 1: Deletar um Node sem filhos na direita");

        $inOrder = $this->avlTree->inOrder($newNode);
        $this->assertSame($inOrder, "0, 1, 2, 3, 4, 5, 7, 8", "Deve retornar uma lista de valores InOrder sem o valor deletado");
    }

    public function testInOrder()
    {
        $this->initTree();

        $inOrder = $this->avlTree->inOrder($this->root);
        $this->assertSame($inOrder, "1, 2, 3, 4, 5, 6, 7, 8", "Deve retornar uma lista de valores InOrder");
    }

    public function testPostOrder()
    {
        $this->initTree();

        $inOrder = $this->avlTree->postOrder($this->root);
        $this->assertSame($inOrder, "1, 3, 2, 5, 8, 7, 6, 4");
    }

    public function testPreOrder()
    {
        $this->initTree();

        $inOrder = $this->avlTree->preOrder($this->root);
        $this->assertSame($inOrder, "4, 2, 1, 3, 6, 5, 7, 8");
    }
}
