"use strict";

export class Notification {
	/**
	 * Matches the Notifications table in the database
	 * @param {int} notification_id 
	 * @param {int} type 
	 * 1 = Application;
	 * 2 = Application accepted;
	 * 3 = New comment on post;
	 * 4 = New reply to comment;
	 * @param {int} user_id 
	 * @param {int} application_id 
	 * @param {int} post_id 
	 * @param {int} comment_id 
	 * @param {boolean} inactive 
	 */

	constructor(notification_id, type, user_id,
		application_id, post_id, comment_id, inactive) {
		this.notification_id = notification_id;
		this.type = type;
		this.user_id = user_id; // foreign key
		this.application_id = application_id; // foreign key
		this.post_id = post_id; // foreign key
		this.comment_id = comment_id; // foreign key
		this.inactive = inactive;
	}
}