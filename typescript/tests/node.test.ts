import BinaryTree from "../src/tree/avlTree/BinaryTree";
import Leaf from "../src/tree/avlTree/Leaf";


test("Deve instanciar um novo Node", () => {
    console.clear()

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
