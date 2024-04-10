import Leaf from "../Leaf";

export default class BinaryTree {

    private output: Array<number> = [];

    getValue(leaf: Leaf | undefined): number {
        return Number(leaf?.value);
    }

    insert(root: Leaf | undefined, value: number): Leaf {

        if (!root) {
            return new Leaf(value);
        }

        if (value < root.value) {
            root.left = this.insert(root.left, value);
            if (root.left.value === value) {
                return root;
            }
        } else if (value > root.value) {
            root.right = this.insert(root.right, value);
            if (root.right.value === value) {
                return root;
            }
        }

        return root

    }

    includes(root: Leaf | undefined, value: number): boolean {
        if (!root) return false
        const queue = [root];
        while (queue.length > 0) {
            const current = queue.shift();
            if (current?.value === value) return true;
            if (current?.left) queue.push(current.left);
            if (current?.right) queue.push(current.right);
        }
        return false;
    }

    preOrder(leaf: Leaf | undefined): string {
        let output = [];

        output.push(this.getValue(leaf));

        if (leaf?.left) {
            output.push(this.preOrder(leaf.left));
        }
        if (leaf?.right) {
            output.push(this.preOrder(leaf.right));
        }

        return output.join(", ");
    }

    postOrder(leaf: Leaf | undefined): string {
        let output = [];

        if (leaf?.left) {
            output.push(this.postOrder(leaf.left));
        }
        if (leaf?.right) {
            output.push(this.postOrder(leaf.right));
        }

        output.push(this.getValue(leaf));

        return output.join(", ");
    }

    inOrder(leaf: Leaf | undefined): any {
        let output = [];

        if (leaf?.left) {
            output.push(this.inOrder(leaf?.left));
        }

        output.push(this.getValue(leaf));

        if (leaf?.right) {
            output.push(this.inOrder(leaf?.right));
        }

        return output.join(", ");
    }
}