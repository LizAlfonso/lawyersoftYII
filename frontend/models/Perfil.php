<?php

namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use common\models\User;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\db\Expression;

/**
 * This is the model class for table "perfil".
 *
 * @property string $id
 * @property string $user_id
 * @property string $nombre
 * @property string $apellido
 * @property string $fecha_nacimiento
 * @property string $created_at
 * @property string $updated_at
 * @property integer $genero_id
 *
 * @property Genero $genero
 */
class Perfil extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'perfil';
    }

     /**
        * behaviors
        */

    public function behaviors()
    {
        return [
            'timestamp' => [
            'class' => 'yii\behaviors\TimestampBehavior',  //para los datetime ...usa la ruta absoluta así q no hay q agregar una sentencia Use
            'attributes' => [
                                ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                                ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                            ],
            'value' => new Expression('NOW()'),
                           ],
               ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'genero_id'], 'required'],
            [['user_id', 'genero_id'], 'integer'],
            [['genero_id'],'in', 'range'=>array_keys($this->getGeneroLista())],   
            [['fecha_nacimiento', 'created_at', 'updated_at'], 'safe'],
            [['fecha_nacimiento'], 'date', 'format'=>'Y-m-d'],
            [['nombre', 'apellido'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'genero_id' => 'Genero ID',
            'generoNombre' => Yii::t('app', 'Genero'), //////////mirar
            'userLink' => Yii::t('app', 'User'), 
            'perfilIdLink' => Yii::t('app', 'Perfil'),

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenero()
    {
        return $this->hasOne(Genero::className(), ['id' => 'genero_id']);
    }

    

    /**
 * @return \yii\db\ActiveQuery
 */

    public function getGeneroNombre()
    {
        return $this->genero->genero_nombre;  //////mirar
    }
/**
 * get lista de generos para lista desplegable
 */

public static function getGeneroLista()
{
    $droptions = Gender::find()->asArray()->all();
    return ArrayHelper::map($droptions, 'id', 'genero_nombre');    //////mirar
}

/**
 * @return \yii\db\ActiveQuery
 */
public function getUser()
{
    return $this->hasOne(User::className(), ['id' => 'user_id']);
}

/**
 * @get Username
 */
public function getUsername()
{
    return $this->user->username;
}
/**
 * @getUserId
 */
public function getUserId()
{
    return $this->user ? $this->user->id : 'ninguno';
}

/**
 * @getUserLink
 */

public function getUserLink()
{
    $url = Url::to(['user/view', 'id'=>$this->UserId]);
    $opciones = [];
    return Html::a($this->getUserName(), $url, $opciones);
}
/**
 * @getProfileLink
 */

public function getPerfilIdLink()
{
    $url = Url::to(['perfil/update', 'id'=>$this->id]);
    $opciones = [];
    return Html::a($this->id, $url, $opciones);
}


}
