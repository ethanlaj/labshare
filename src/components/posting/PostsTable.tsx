import React, { Component } from "react";
import Post from "../../models/post";
import ProfilePic from "../common/ProfilePic";
import Table from "../common/Table";
import Column from "../../models/column";

interface PostsTableProps {
	posts: Post[];
}

class PostsTable extends Component<PostsTableProps> {
	columns: Column[] = [
		{
			key: "profilepic",
			label: "",
			content: (post: Post) => {
				return (
					<ProfilePic
						username={post.username}
						profilepic={post.profilepic}
					></ProfilePic>
				);
			},
		},
		{
			path: "fullName",
			label: "User",
		},
		{ path: "creationDate", label: "Posted On" },
		{ path: "title", label: "Post Title" },
		{ path: "zip", label: "Zip Code" },
	];

	render() {
		const { posts } = this.props;

		return (
			<Table columns={this.columns} data={posts} idProperty="post_id" />
		);
	}
}

export default PostsTable;
