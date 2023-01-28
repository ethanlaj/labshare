import Comment from "../models/comment";

export default interface Post {
	post_id: number;
	creationDate: string;
	author_id: number;
	username: string;
	fullName: string;
	profilepic: string;
	title: string;
	content: string;
	zip?: number;
	lat?: number;
	lon?: number;
	hasSaved: boolean;
	hasApplied: boolean;
	comments: Comment[];
}
