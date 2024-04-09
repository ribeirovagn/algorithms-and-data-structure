export default class Leaf {

    public value: number;
    public height?: number;
    public left?: Leaf;
    public right?: Leaf;

    constructor(value: number, height?: number, left?: Leaf, right?: Leaf) {
        this.value = value;
        this.height = height;
        this.left = left;
        this.right = right;
    }
}