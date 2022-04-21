<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contest".
 *
 * @property int $ID
 * @property string $contest_id
 * @property string $contest_name
 * @property string $contest_start_date
 * @property string $contest_end_date
 * @property int $contest_persons
 * @property string $contest_participants
 * @property string|null $contest_area
 * @property string|null $contest_image
 * @property string $created_by
 * @property string $created_on
 */
class Contest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contest';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contest_id', 'contest_name', 'contest_start_date', 'contest_end_date', 'contest_persons', 'created_by', 'created_on'], 'required'],
            [['contest_start_date', 'contest_end_date', 'created_on'], 'safe'],
            [['contest_persons'], 'integer'],
           // [['contest_participants'], 'string'],
            [['contest_id'], 'string', 'max' => 30],
            [['contest_name', 'contest_area', 'contest_image'], 'string', 'max' => 255],
            [['created_by'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'contest_id' => 'Contest ID',
            'contest_name' => 'Contest Name',
            'contest_start_date' => 'Contest Start Date',
            'contest_end_date' => 'Contest End Date',
            'contest_persons' => 'Contest Persons',
            'contest_participants' => 'Contest Participants',
            'contest_area' => 'Contest Area',
            'contest_image' => 'Contest Image',
            'created_by' => 'Created By',
            'created_on' => 'Created On',
        ];
    }
}
