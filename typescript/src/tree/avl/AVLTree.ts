import Leaf from "../Leaf";

export default class AVLTree {


    includes(leaf: Leaf | undefined, value: number): boolean {
        if (leaf === undefined) {
            return false;
        }

        const root = [leaf];
        while (root.length != 0) {
            const current = root.shift();
            if (current?.value === value) return true;
            if (current?.left) root.push(current.left);
            if (current?.right) root.push(current.right);
        }

        return false;
    }

    insert(leaf: Leaf | undefined, value: number): Leaf {
        if (leaf instanceof Leaf) {
            if (value < leaf.value) {
                const newLeafLeft = this.insert(leaf.left, value);
                return this.rebalance(this.leftReplace(
                    leaf,
                    newLeafLeft,
                    Math.max(this.getHeight(newLeafLeft), this.getHeight(leaf.right) + 1)
                ));
            }

            const newLeafRight = this.insert(leaf?.right, value);
            return this.rebalance(
                this.rightReplace(
                    leaf!,
                    newLeafRight,
                    Math.max(this.getHeight(newLeafRight), this.getHeight(leaf?.right)) + 1
                )
            );
        }

        return new Leaf(value);
    }

    delete(leaf: Leaf | undefined, value: number): Leaf | undefined {
        if (leaf instanceof Leaf) {
            if (value === leaf.value) {
                if (leaf.left === undefined && leaf.right === undefined) {
                    leaf = undefined
                    return leaf;
                }
                else if (leaf.left === undefined && leaf.right instanceof Leaf) {
                    leaf = leaf.right;
                    return leaf;
                }
                else if (leaf.left instanceof Leaf && leaf.right === undefined) {
                    leaf = leaf.left;
                    return leaf;
                }
                else {
                    let current = leaf.right;
                    while (current?.left instanceof Leaf) {
                        current = leaf.left;
                    }
                    leaf.value = current?.value!;
                    leaf.right = this.delete(leaf.right, current?.value!);
                }
            } else if (value < leaf?.value!) {
                leaf.left = this.delete(leaf?.left, value);
            } else if (value > leaf?.value!) {
                leaf.right = this.delete(leaf?.right, value);
            }

            const balanceFactor = this.balanceFactor(leaf!);

            if (balanceFactor != -1 && balanceFactor != 0 && balanceFactor != 1) {
                leaf = this.rebalance(leaf!);
            }
        }
        return leaf;
    }

    protected getHeight(leaf: Leaf | undefined): number {
        return leaf ? Number(leaf.height) : 0;
    }

    protected rebalance(leaf: Leaf): Leaf {
        const bf = this.balanceFactor(leaf);
        const fl = leaf.left ? this.balanceFactor(leaf.left) : 0;
        const fr = leaf.right ? this.balanceFactor(leaf.right) : 0;

        if (bf === 2) {
            if (fl === -1) {
                leaf = this.leftReplace(leaf, this.leftRotate(leaf.left!));
                return this.rightRotate(leaf);
            }
            if (fl === 1) {
                return this.rightRotate(leaf);
            }
        }

        if (bf === -2) {
            if (fr === 1) {
                leaf = this.rightReplace(leaf, this.rightRotate(leaf.right!));
            }
            if (fr === -1) {
                return this.leftRotate(leaf);
            }
        }

        return leaf;
    }

    protected leftRotate(leaf: Leaf): Leaf {
        const left = leaf.left;
        const rl = leaf.right?.left;
        const rr = leaf.right?.right;

        const height = Math.max(this.getHeight(leaf), this.getHeight(rl)) + 1;
        console.log(height)
        return new Leaf(
            Number(leaf.right?.value),
            Math.max(height, this.getHeight(rr)) + 1,
            new Leaf(leaf.value, height, left, rl),
            rr
        )
    }

    protected rightRotate(leaf: Leaf): Leaf {
        const ll = leaf.left?.left;
        const lr = leaf.left?.right;
        const right = leaf.right?.right;

        const height = Math.max(this.getHeight(lr) + 1);
        console.log(height);
        return new Leaf(
            Number(leaf.left?.value),
            Math.max(height, this.getHeight(ll) + 1),
            ll,
            new Leaf(
                leaf.value, height, lr, right)
        )
    }

    protected leftReplace(leaf: Leaf, newLeaf: Leaf, height?: number): Leaf {
        height ? height : leaf.height;
        return new Leaf(leaf.value, height, newLeaf, leaf.right);
    }

    protected rightReplace(leaf: Leaf, newLeaf?: Leaf, height?: number): Leaf {
        height ? height : leaf.height;
        return new Leaf(leaf.value, height, leaf.left, newLeaf);
    }

    protected balanceFactor(leaf: Leaf) {
        return this.getHeight(leaf.left) - this.getHeight(leaf.right);
    }
}