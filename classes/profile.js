"use strict";

export class Profile {
	/**
	 * Matches the Profiles table in the database
	 * @param {int} user_id 
	 * @param {string} quals_degrees Qualifications/Degrees
	 * @param {string} areaOfStudy 
	 * @param {string} yearsInField 
	 * @param {string} secondaryAreaOfStudy 
	 * @param {string} about 
	 * @param {string} achievements_interests 
	 * @param {string} avatar
	 */
	constructor(user_id, quals_degress, areaOfStudy,
		yearsInField, secondaryAreaOfStudy, about,
		achievements_interests, avatar) {

		this.user_id = user_id;
		this.quals_degress = quals_degress;
		this.areaOfStudy = areaOfStudy;
		this.yearsInField = yearsInField;
		this.secondaryAreaOfStudy = secondaryAreaOfStudy;
		this.about = about;
		this.achievements_interests = achievements_interests;
		this.avatar = avatar;
	}
}