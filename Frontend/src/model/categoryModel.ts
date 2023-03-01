/**
 * Model of a category. Contains all necessary fields.
 * Used in apiCalls file format the datas retrieved from the backend.
 */
export class Category {
    /**
     * Static field to increment the id of the category so we can keep track of each one
     */
    private static idCounter: number = 0;

    /**
     * Each category will have an ID and title
     */
    id: number;
    title: string;

    /**
     * Will assign category title to the input
     * Will increment idCounter
     * @param title 
     */
    constructor(title: string) {
        this.id = Category.idCounter;
        Category.idCounter++;

        this.title = title;
    }
}