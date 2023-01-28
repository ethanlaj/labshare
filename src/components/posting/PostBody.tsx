import React from "react";

interface PostBodyProps {
	title: string;
	content: string;
}

const PostBody = ({ title, content }: PostBodyProps) => {
	return (
		<main id="post">
			<div id="postTitleWithDropdown">
				<h1 id="postTitle">{title}</h1>
				<div className="dropdown-center dropend">
					<button
						className="commentButton btn dropdown-toggle"
						type="button"
						data-bs-toggle="dropdown"
						aria-expanded="false"
					>
						...
					</button>
					<ul className="dropdown-menu">
						<li>
							<a
								className="dropdown-item"
								href="./editPost.php?id=<?PHP echo $post->post_id ?>"
							>
								Edit
							</a>
						</li>
						<li>
							<button
								className="dropdown-item"
								data-bs-toggle="modal"
								data-bs-target="#deletePost"
							>
								Delete
							</button>
						</li>
					</ul>
				</div>
			</div>
			<p id="postText">{content}</p>
		</main>
	);
};

export default PostBody;
