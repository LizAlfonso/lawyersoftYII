<?php

namespace backend\models;

use common\models\User;
use Yii;

/**
 * This is the model class for table "estado".
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $valor
 */
class Estado extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'estado';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        [['nombre', 'valor'], 'required'],
        [['valor'], 'integer'],
        [['nombre'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        'id' => 'ID',
        'nombre' => 'Nombre',
        'valor' => 'Valor',
        ];
    }

    //un estado lo pueden tener varios usuarios
    public function getUsers() 
    { 
       return $this->hasMany(User::className(), ['estado_id' => 'id']); 
   } 

}
