/**
 * Model of a single User. Contains all the necessary fields.
 * Used in the apiCalls file format the datas retrieved from the backend.
 */
export class User {

	/**
	 * Static field to increment the id of the user each time we are creating a new one. 
	 */
	//private static idCounter: number = 0;

	/**
	 * For now on, each user has an id, username, password, email, fname, and lname that are public. 
	 *
	 */
	id: number;
	username: string;
	// password: string;
	email: string;
	fname: string;
	lname: string;
	bio: string;
	// security_answer_1: string;
	// security_answer_2: string;
	// security_answer_3: string;
	// security_question_1: string;
	// security_question_2: string;
	// security_question_3: string;
	//profile_photo: string;
	token: string;

	//Creates a user
	// constructor(username: string, token: string, email: string,id: number,password: string, security_answer_1: string,security_answer_2: string,security_answer_3: string,security_question_1: string,security_question_2: string,security_question_3: string,) {
	constructor(
		username: string,
		token: string,
		email: string,
		id: number,
		fname: string,
		lname: string,
		bio: string
	) {
		// We set the id automatically with the static field, so it is auto incrementing.
		this.id = id;
		//We set the security questions and answers that were input

		// We create a user from the properties passed in parameters.
		this.username = username;
		this.email = email;
		this.token = token;
		this.fname = fname;
		this.lname = lname;
		this.bio = bio;
		//this.profile_photo ="/uploads/profile_images/default_profile_pic.jpg";
		//this.setname();

	}
	setname(): void {
		//const length = (Math.random() * this.username.length) + 1;
		//this.fname = this.username.substring(0, this.username.length / 2);
		//this.lname = this.username.substring(this.username.length / 2, this.username.length);

		//if (this.userList.find(user => user.username === this.currentUser.username) !== undefined) {
		//	this.userList.find(user => user.username === this.currentUser.username).fname = this.currentUser.fname;
		//}
	}


}