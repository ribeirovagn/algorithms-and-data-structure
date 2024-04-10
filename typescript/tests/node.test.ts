import AVLTree from "../src/tree/avlTree/AVLTree";
import BinaryTree from "../src/tree/avlTree/BinaryTree";

console.clear()

test("Binary Tree", () => {

    const binaryTree = new BinaryTree();
    let root = binaryTree.insert(undefined, 4);

    root = binaryTree.insert(root, 2);
    root = binaryTree.insert(root, 8);
    root = binaryTree.insert(root, 7);
    root = binaryTree.insert(root, 1);
    root = binaryTree.insert(root, 3);
    root = binaryTree.insert(root, 6);
    root = binaryTree.insert(root, 5);

    expect(binaryTree.includes(root, 8)).toBeTruthy();
    expect(binaryTree.includes(root, 9)).toBeFalsy();

    const preOrder = binaryTree.preOrder(root);
    expect(preOrder).toEqual("4, 2, 1, 3, 8, 7, 6, 5");

    const postOrder = binaryTree.postOrder(root);
    expect(postOrder).toEqual("1, 3, 2, 5, 6, 7, 8, 4");

    const inOrder = binaryTree.inOrder(root);
    expect(inOrder).toEqual("1, 2, 3, 4, 5, 6, 7, 8");
});

test("AVL Tree", () => {

    const avl = new AVLTree();
    const binaryTree = new BinaryTree();

    let root = avl.insert(undefined, 4);

    root = avl.insert(root, 1);
    root = avl.insert(root, 2);
    root = avl.insert(root, 7);
    root = avl.insert(root, 8);
    root = avl.insert(root, 3);
    root = avl.insert(root, 6);
    root = avl.insert(root, -9);
    root = avl.insert(root, 5);

    const _del = -9
    const deleted = avl.delete(root, _del);

    expect(avl.includes(root, 8)).toBeTruthy();
    expect(avl.includes(deleted, _del)).toBeFalsy();

    const inOrder = binaryTree.inOrder(root);

    expect(inOrder).toEqual("1, 2, 3, 4, 5, 6, 7, 8");
});