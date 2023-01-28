import React from "react";

interface ProfilePicState {
	username: string;
	profilepic: string;
}

const ProfilePic = ({ profilepic, username }: ProfilePicState) => {
	return <img src={profilepic} alt={username}></img>;
};

export default ProfilePic;
