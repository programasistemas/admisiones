<?php
//Arreglo con las expresiones regex que usaremos en relación al tipo de dato.
function getRegexExpressions()
{
    return array(
        //Para validar textos, acepta todo tipo de dato excluyendo signos raros y números:
        'text'              => '/^([a-zA-ZáéíóúÁÉÍÓÚñÑ.]+( )*)+$/',
        'textOrEmpty'       => '/^([a-zA-ZáéíóúÁÉÍÓÚñÑ.]+( )*)*$/',

        //Permite multilinea, comas, puntos, comillas simples y dobles.
        'textComplete'      => '/^([a-zA-Z0-9áéíóúÁÉÍÓÚñÑ., \n\-«»\"@]*)*$/',

        //Validar nombres de 3 a 15 caracteres:
        'name'              => '/^[a-zA-ZñÑ]{3,15}$/',

        //Validar nombres que puedan existir o no, (hasta 3)
        'name2'             => '/^([a-zA-ZñÑ]{3,15}( [a-zA-ZñÑ]{3,15}){0,2})?$/',

        //Valida el correo ingresado:
        'email'             => '/^(([^<>()\[\]\\.,;:\s@\"]+(\.[^<>()\[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/',

        //Valida una fecha (input:date):
        'date'              => '/^[0-9]{4}(-[0-9]{2}){2}$/',

        //Valida el genero guardado, debe ser FEMENINO o MASCLIUINO
        'gender'            => '/^(FEMENINO)|(MASCULINO)$/',

        //Valida un número de identidad
        'id'                => '/^[0-9]{4,10}$/',

        //Valida el código del icfes. formato: (vg)(ac)2021 0 1234567
        'icfes_code'        => '/^((VG)|(AC))[0-9]{12}$/',

        //Dirección residencial, acepta todos los valores, excluyendo unicamente los signos (ignorando #.-)
        'addres'            => '/^([a-zA-ZáéíóúÁÉÍÓÚñÑ0-9#.-]+ *)+$/',

        //Extensiones permitidas en los documentos.
        'doc'               => '/^(pdf)$/', //< NO MODIFICAR, PROCESO DE INSCRIPCIÓN VALIDA LOS ARCHIVOS.

        //Nombre de barrios, acepta letras puntos y números.
        'nbhood'            => '/^([a-zA-ZáéíóúÁÉÍÓÚñÑ.0-9]+( )*)+$/',

        //Valida el nivel de sisben 4.
        'sisben_status'     => '/^(A[1-5])|(B[1-7])|(C1[0-8])|(C[1-9])|(D1[0-9])|(D2[0-1])|(D[1-9])$/',

        // Nombre de periodo academico
        'academic_period'   => '/^([0-9]{4}\-[Aa|Bb]{1})$/',

        //Valida la contraseña según los requisitos mínimos establecidos en el formulario de cambio de contraseña.
        'password'          => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$#!%*?&])[A-Za-z\d@$!#%*?&]{8,}$/',

        //Valida el pin ingresado en el formulario de validacion de pines
        'pinRegex'          => '/^[A-Za-z0-9]+$/',

        //Valida el ingreso de solo caracteres numericos
        'onlyNumbers'       => '/^(0|[1-9][0-9]*)$/',
        'numbersOrEmpty'    => '/^(0|[1-9][0-9]*)?$/',
        'scores'            => '/^(0|0\.[0-9]+|[1-9][0-9]*(.[0-9]+)?)$/',

        //Valida el ingreso de solo palabras
        'onlyWords'         => '/^([A-Za-záéíóúñÑ\s])*$/',

        'phone'             => '/^[1-9][0-9 ]*$/',
        'sisbenOrEmpty'     => '/^((A[1-5])|(B[1-7])|(C1[0-8])|(C[1-9])|(D1[0-9])|(D2[0-1])|(D[1-9]))?$/',
        //'eps'               => '/^[A-Z\-0-9]+$/',
        //'estrato'           => '/^[1-7]$/',

        //Formato del código para verificar emails.
        'codeEmail'         =>  '/^U-[0-9A-Z]{5}$/',
    );
}
