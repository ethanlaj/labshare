"use strict";

export class Notification {
	/**
	 * Matches the Notifications table in the database
	 * @param {int} notification_id 
	 * @param {string} kind 
	 * NEW_APP = 'Application';
	 * APP_ACCEPT = Application accepted;
	 * APP_DECLINE = New comment on post;
	 * POST_SAVED = New reply to comment;
	 * @param {int} applicant_id 
	 * @param {int} post_id 
	 * @param {boolean} inactive 
	 */

	constructor(notification_id, kind, applicant_id, post_id, inactive) {
		this.notification_id = notification_id;
		this.kind = kind;
		this.applicant_id = applicant_id; // foreign key
		this.post_id = post_id; // foreign key
		this.inactive = inactive;
	}
}