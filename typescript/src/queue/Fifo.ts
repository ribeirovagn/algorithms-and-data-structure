export default class Fifo {

    queue: Array<string> = [];

    init() {
        const count = 20;

        for (let i = 0; i < count; i++) {
            const name = String.fromCharCode(65 + Math.random() * 26).repeat(1 + Math.random() * 10);

            this.queue.push(name);
        }

        console.log(this.queue);
    }
}