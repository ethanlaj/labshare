"use strict";

export class Notification {
	/**
	 * Matches the Notifications table in the database
	 * @param {int} notification_id 
	 * @param {int} kind 
	 * 1 = Application;
	 * 2 = Application accepted;
	 * 3 = New comment on post;
	 * 4 = New reply to comment;
	 * @param {int} user_id 
	 * @param {int} post_id 
	 * @param {int} comment_id 
	 * @param {boolean} inactive 
	 */

	constructor(notification_id, kind, user_id, post_id, comment_id, inactive) {
		this.notification_id = notification_id;
		this.kind = kind;
		this.user_id = user_id; // foreign key
		this.post_id = post_id; // foreign key
		this.comment_id = comment_id; // foreign key
		this.inactive = inactive;
	}
}