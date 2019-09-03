<?php

namespace backend\modules\staff\models;

use Yii;

/**
 * This is the model class for table "staff".
 *
 * @property int $staff_id
 * @property string $staff_no
 * @property string $user_name
 * @property string $user_password_hash
 * @property string $staff_email
 * @property string $staff_name
 * @property string $staff_name_pub
 * @property string $staff_title
 * @property string $staff_edu
 * @property int $is_academic
 * @property int $position_id
 * @property int $position_status
 * @property int $working_status
 * @property string $leave_start
 * @property string $leave_end
 * @property string $leave_note
 * @property string $rotation_post
 * @property string $staff_expertise
 * @property string $staff_gscholar
 * @property string $officephone
 * @property string $handphone1
 * @property string $handphone2
 * @property string $staff_ic
 * @property string $staff_dob
 * @property string $date_begin_umk
 * @property string $date_begin_service
 * @property string $staff_note
 * @property string $personal_email
 * @property string $ofis_location
 * @property string $staff_cv
 * @property string $staff_img
 * @property int $teach_pg
 * @property int $staff_level
 * @property string $staff_interest
 * @property int $staff_department
 * @property int $is_super
 * @property int $progress
 * @property int $total_progress
 * @property int $trash
 * @property int $publish
 * @property int $user_active
 * @property int $user_deleted
 * @property int $user_account_type
 * @property string $user_suspension_timestamp
 * @property string $user_last_login_timestamp
 * @property int $user_failed_logins
 * @property int $user_last_failed_login
 * @property string $user_password_reset_hash
 * @property string $user_password_reset_timestamp
 * @property string $session_id
 */
class Staff extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['staff_no', 'user_id', 'user_name', 'user_password_hash', 'staff_email', 'staff_name', 'staff_name_pub', 'staff_title', 'staff_edu', 'is_academic', 'position_id', 'position_status', 'leave_start', 'leave_end', 'leave_note', 'rotation_post', 'staff_expertise', 'staff_gscholar', 'officephone', 'handphone1', 'handphone2', 'staff_ic', 'staff_dob', 'date_begin_umk', 'date_begin_service', 'staff_note', 'personal_email', 'ofis_location', 'staff_cv', 'staff_img', 'teach_pg', 'staff_level', 'staff_interest', 'staff_department', 'is_super', 'progress', 'total_progress', 'user_suspension_timestamp', 'user_last_login_timestamp', 'user_last_failed_login', 'user_password_reset_hash', 'user_password_reset_timestamp', 'session_id'], 'required'],
			
			[['user_id'], 'required', 'on' => 'reload'],
			
            [['user_id', 'is_academic', 'position_id', 'position_status', 'working_status', 'teach_pg', 'staff_level', 'staff_department', 'is_super', 'progress', 'total_progress', 'trash', 'publish', 'user_active', 'user_deleted', 'user_account_type', 'user_suspension_timestamp', 'user_last_login_timestamp', 'user_failed_logins', 'user_last_failed_login', 'user_password_reset_timestamp'], 'integer'],
			
			
            [['leave_start', 'leave_end', 'staff_dob', 'date_begin_umk', 'date_begin_service'], 'safe'],
			
            [['leave_note', 'staff_interest'], 'string'],
			
			
            [['staff_no'], 'string', 'max' => 10],
            [['user_name', 'staff_img'], 'string', 'max' => 50],
            [['user_password_hash'], 'string', 'max' => 255],
            [['staff_email', 'staff_name', 'staff_note', 'personal_email', 'ofis_location'], 'string', 'max' => 100],
            [['staff_name_pub', 'session_id'], 'string', 'max' => 200],
            [['staff_title', 'officephone', 'handphone1', 'handphone2'], 'string', 'max' => 20],
			
            [['staff_edu', 'staff_expertise', 'staff_cv'], 'string', 'max' => 300],
            [['rotation_post', 'staff_gscholar'], 'string', 'max' => 500],
            [['staff_ic'], 'string', 'max' => 15],
            [['user_password_reset_hash'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'staff_id' => 'Staff ID',
            'staff_no' => 'Staff No',
            'user_name' => 'User Name',
            'user_password_hash' => 'User Password Hash',
            'staff_email' => 'Staff Email',
            'staff_name' => 'Staff Name',
            'staff_name_pub' => 'Staff Name Pub',
            'staff_title' => 'Staff Title',
            'staff_edu' => 'Staff Edu',
            'is_academic' => 'Is Academic',
            'position_id' => 'Position ID',
            'position_status' => 'Position Status',
            'working_status' => 'Working Status',
            'leave_start' => 'Leave Start',
            'leave_end' => 'Leave End',
            'leave_note' => 'Leave Note',
            'rotation_post' => 'Rotation Post',
            'staff_expertise' => 'Staff Expertise',
            'staff_gscholar' => 'Staff Gscholar',
            'officephone' => 'Officephone',
            'handphone1' => 'Handphone1',
            'handphone2' => 'Handphone2',
            'staff_ic' => 'Staff Ic',
            'staff_dob' => 'Staff Dob',
            'date_begin_umk' => 'Date Begin Umk',
            'date_begin_service' => 'Date Begin Service',
            'staff_note' => 'Staff Note',
            'personal_email' => 'Personal Email',
            'ofis_location' => 'Ofis Location',
            'staff_cv' => 'Staff Cv',
            'staff_img' => 'Staff Img',
            'teach_pg' => 'Teach Pg',
            'staff_level' => 'Staff Level',
            'staff_interest' => 'Staff Interest',
            'staff_department' => 'Staff Department',
            'is_super' => 'Is Super',
            'progress' => 'Progress',
            'total_progress' => 'Total Progress',
            'trash' => 'Trash',
            'publish' => 'Publish',
            'user_active' => 'User Active',
            'user_deleted' => 'User Deleted',
            'user_account_type' => 'User Account Type',
            'user_suspension_timestamp' => 'User Suspension Timestamp',
            'user_last_login_timestamp' => 'User Last Login Timestamp',
            'user_failed_logins' => 'User Failed Logins',
            'user_last_failed_login' => 'User Last Failed Login',
            'user_password_reset_hash' => 'User Password Reset Hash',
            'user_password_reset_timestamp' => 'User Password Reset Timestamp',
            'session_id' => 'Session ID',
        ];
    }
}
