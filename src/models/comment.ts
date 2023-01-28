export default interface Comment {
	comment_id: number;
	author_id: number;
	parent_id?: number;
	creationDate: string;
	content: string;
	username: string;
	fullName: string;
	profilepic: string;
	children: Comment[];
}
