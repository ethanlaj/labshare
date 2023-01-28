import React, { Fragment, useState, useEffect } from "react";
import Comments from "./Comments";
import PostBody from "./PostBody";
import PostHeader from "./PostHeader";
import PostModel from "../../models/post";
import postingService from "../../services/http/postingService";
import "../../stylesheets/posting/post.css";

interface PostProps {
	post_id: number;
}

const Post = ({ post_id }: PostProps): JSX.Element => {
	const [post, setPost] = useState<PostModel>({} as PostModel);

	useEffect(() => {
		const loadPost = async () => {
			const post = await postingService.getPost(post_id);
			setPost(post);
		};

		loadPost();
	}, [post_id]);

	const {
		fullName,
		author_id,
		profilepic,
		creationDate,
		username,
		hasSaved,
		hasApplied,
		title,
		content,
		comments,
	} = post;
	return (
		<Fragment>
			<PostHeader
				fullName={fullName}
				author_id={author_id}
				profilepic={profilepic}
				creationDate={creationDate}
				username={username}
				hasSaved={hasSaved}
				hasApplied={hasApplied}
			></PostHeader>
			<PostBody title={title} content={content}></PostBody>
			<hr></hr>
			<Comments comments={comments}></Comments>
		</Fragment>
	);
};

export default Post;
