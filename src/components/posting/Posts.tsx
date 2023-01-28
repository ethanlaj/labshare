import React, { Fragment, useState, useEffect } from "react";
import Post from "../../models/post";
import PostsTable from "./PostsTable";
import postingService from "../../services/http/postingService";
import "../../stylesheets/posting/posts.css";

const Posts = () => {
	const [posts, setPosts] = useState<Post[]>([]);

	useEffect(() => {
		loadPosts();
	}, []);

	const loadPosts = async () => {
		const posts = await postingService.getPosts();
		setPosts(posts);
	};

	return (
		<Fragment>
			<header>
				<h2>Posts</h2>
				<div>
					<a
						id="createPostBtn"
						className="btn btn-outline-success"
						href="createPost.php"
					>
						Create A Post
					</a>
					<form id="zipCodeForm">
						<input type="hidden" id="search" name="search" />
						<input type="hidden" id="type" name="type" />
						<div className="form-group">
							<input
								placeholder="Zip Code"
								className="form-control"
								name="zip"
								type="text"
							/>
						</div>
						<input
							id="addFilter"
							className="btn btn-outline-primary"
							type="submit"
							value="Add Sort"
						/>
					</form>
				</div>
			</header>

			<PostsTable posts={posts}></PostsTable>
		</Fragment>
	);
};

export default Posts;
