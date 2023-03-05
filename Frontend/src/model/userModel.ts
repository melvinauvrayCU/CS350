/**
 * Model of a single User. Contains all the necessary fields.
 * Used in the apiCalls file format the datas retrieved from the backend.
 */
export class User {

	/**
	 * Static field to increment the id of the user each time we are creating a new one. 
	 */
	private static idCounter: number = 0;

	/**
	 * For now on, each user has an id, username, password, email, fname, and lname that are public. 
	 *
	 */
	id: number;
	username: string;
	password: string;
	email: string;
	fname: string;
	lname: string;
	bio: string;

	//Creates a user
	constructor(username: string, password: string, email: string) {
		// We set the id automatically with the static field, so it is auto incrementing.
		this.id = User.idCounter;
		User.idCounter++;

		// We create a user from the properties passed in parameters.
		this.username = username;
		this.password = password;
		this.email = email;
		this.fname = "";
		this.lname = "";
		this.bio = "";
		this.setname();

	}
	setname(): void {
		const length = (Math.random() * this.username.length) + 1;
		this.fname = this.username.substring(1, length / 2);
		this.lname = this.username.substring(length / 2, length);

		// if (this.userList.find(user => user.username === this.currentUser.username) !== undefined) {
		// 	this.userList.find(user => user.username === this.currentUser.username).fname = this.currentUser.fname;
		// }
	}
}