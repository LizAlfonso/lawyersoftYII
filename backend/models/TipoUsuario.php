<?php

namespace backend\models;

use common\models\User; 
use Yii;

/**
 * This is the model class for table "tipo_usuario".
 *
 * @property integer $id
 * @property string $nombre
 * @property integer $valor
 */
class TipoUsuario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipo_usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        [['id', 'nombre', 'valor'], 'required'],
        [['id', 'valor'], 'integer'],
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

    //un tipo de usuario lo pueden tener varios usuarios
    public function getUsers() 
    { 
       return $this->hasMany(User::className(), ['tipo_usuario_id' => 'id']); 
   }  

}
