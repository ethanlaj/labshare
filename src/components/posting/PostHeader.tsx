import React from "react";
import ProfilePic from "../common/ProfilePic";

interface PostHeaderProps {
	fullName: string;
	author_id: number;
	profilepic: string;
	creationDate: string;
	username: string;
	hasSaved: boolean;
	hasApplied: boolean;
}

const PostHeader = (props: PostHeaderProps) => {
	return (
		<div id="postHeader">
			<ProfilePic
				profilepic={props.profilepic}
				username={props.username}
			></ProfilePic>

			<div id="nextToProfilePic">
				<a href={"../profiles/profile.php?id=" + props.author_id}>
					{props.fullName}
				</a>
				<p>{props.creationDate}</p>

				<div id="actionButtons">
					<button
						id="savePostBtn"
						className="btn btn-sm btn-outline-primary"
					>
						{props.hasSaved ? "Unsave" : "Save"}
					</button>
					<button
						id="applyToPostBtn"
						disabled={props.hasApplied}
						className="btn btn-sm btn-outline-success"
					>
						{props.hasApplied ? "Applied" : "Apply"}
					</button>
					<button
						id="initReportBtn"
						className="btn btn-sm btn-outline-danger"
						data-bs-toggle="modal"
						data-bs-target="#reportPost"
					>
						Report
					</button>
				</div>
			</div>
		</div>
	);
};

export default PostHeader;
