<?php

$fields = [
    'firstName'                         => ['column_name' => 'primer_nombre_aspirante',                  'table' => 'v_general_datos_basicos',                       'report_column_name' => 'PRIMER NOMBRE'],
    'secondName'                        => ['column_name' => 'segundo_nombre_aspirante',                 'table' => 'v_general_datos_basicos',                       'report_column_name' => 'SEGUNDO NOMBRE'],
    'firstSurname'                      => ['column_name' => 'primer_apellido_aspirante',                'table' => 'v_general_datos_basicos',                       'report_column_name' => 'PRIMER APELLIDO'],
    'secondSurname'                     => ['column_name' => 'segundo_apellido_aspirante',               'table' => 'v_general_datos_basicos',                       'report_column_name' => 'SEGUNDO NOMBRE'],
    'age'                               => ['column_name' => 'edad',                                     'table' => 'v_general_datos_basicos',                       'report_column_name' => 'EDAD'],

    'icfesCode'                         => ['column_name' => 'codigo_icfes',                             'table' => 'v_general_datos_basicos',                       'report_column_name' => 'AC ICFES'],
    'regionalization'                   => ['column_name' => 'regionalizacion',                          'table' => 'v_general_datos_basicos',                       'report_column_name' => 'REGIONALIZACIÓN'],
    'birthDate'                         => ['column_name' => 'fecha_nacimiento_aspirante',               'table' => 'v_general_datos_basicos',                       'report_column_name' => 'FECHA DE NACIMIENTO DEL ASPIRANTE'],
    'biologicalSex'                     => ['column_name' => 'nombre_sexo_biologico ',                   'table' => 'v_general_datos_basicos',                       'report_column_name' => 'SEXO BIOLÓGICO'],
    'documentExpeditionDate'            => ['column_name' => 'fecha_expedicion_documento',               'table' => 'v_general_datos_basicos',                       'report_column_name' => 'FECHA EXPEDICIÓN DOCUMENTO'],
    'documentExpeditionTown'            => ['column_name' => 'nombre_municipio_expedicion_documento',    'table' => 'v_general_datos_basicos',                       'report_column_name' => 'MUNICIPIO EXPEDICIÓN DOCUMENTO'],
    'documentExpeditionDepartment'      => ['column_name' => 'nombre_departamento_expedicion_documento', 'table' => 'v_general_datos_basicos',                       'report_column_name' => 'DEPARTAMENTO EXPEDICIÓN DOCUMENTO'],
    'birthTown'                         => ['column_name' => 'nombre_municipio_nacimiento',              'table' => 'v_general_datos_basicos',                       'report_column_name' => 'MUNICIPIO NACIMIENTO'],
    'birthDepartment'                   => ['column_name' => 'nombre_departamento_nacimiento',           'table' => 'v_general_datos_basicos',                       'report_column_name' => 'DEPARTAMENTO NACIMIENTO'],
    'procedenceTown'                    => ['column_name' => 'nombre_municipio_procedencia',             'table' => 'v_general_datos_basicos',                       'report_column_name' => 'MUNICIPIO PROCEDENCIA'],
    'procedenceDepartment'              => ['column_name' => 'nombre_departamento_procedencia',          'table' => 'v_general_datos_basicos',                       'report_column_name' => 'DEPARTAMENTO PROCEDENCIA'],
    'graduatedSchool'                   => ['column_name' => 'nombre_sede_colegio_egresado',             'table' => 'v_general_datos_basicos',                       'report_column_name' => 'COLEGIO EGRESADO'],
    'graduatedSchoolDANECode'           => ['column_name' => 'codigo_dane_colegio_egresado',             'table' => 'v_general_datos_basicos',                       'report_column_name' => 'CÓDIGO DANE COLEGIO EGRESADO'],
    'graduatedSchoolTown'               => ['column_name' => 'nombre_municipio_colegio_egresado',        'table' => 'v_general_datos_basicos',                       'report_column_name' => 'MUNICIPIO COLEGIO EGRESADO'],

    'residenceTown'                     => ['column_name' => 'nombre_municipio_residencia',              'table' => 'v_general_datos_residencia',                    'report_column_name' => 'MUNICIPIO RESIDENCIA'],
    'residenceDepartment'               => ['column_name' => 'nombre_departamento_residencia',           'table' => 'v_general_datos_residencia',                    'report_column_name' => 'DEPARTAMENTO RESIDENCIA'],
    'residenceNeighbourhood'            => ['column_name' => 'nombre_barrio_residencia',                 'table' => 'v_general_datos_residencia',                    'report_column_name' => 'BARRIO RESIDENCIA'],
    'residenceDirection'                => ['column_name' => 'direccion_residencia',                     'table' => 'v_general_datos_residencia',                    'report_column_name' => 'DIRECCIÓN RESIDENCIA'],
    'residenceZone'                     => ['column_name' => 'nombre_zona_residencia',                   'table' => 'v_general_datos_residencia',                    'report_column_name' => 'ZONA RESIDENCIA'],

    'studyLevelFather'                  => ['column_name' => 'nombre_escolaridad_padre',                 'table' => 'v_general_datos_familiares',                    'report_column_name' => 'ESCOLARIDAD PADRE'],
    'studyLevelMother'                  => ['column_name' => 'nombre_escolaridad_madre',                 'table' => 'v_general_datos_familiares',                    'report_column_name' => 'ESCOLARIDAD MADRE'],
    'children'                          => ['column_name' => 'numero_hijos',                             'table' => 'v_general_datos_familiares',                    'report_column_name' => 'NÚMERO DE HIJOS'],

    'eps'                               => ['column_name' => 'nombre_eps',                               'table' => 'v_general_datos_salud',                         'report_column_name' => 'EPS'],
    'epsRegimen'                        => ['column_name' => 'nombre_regimen_eps',                       'table' => 'v_general_datos_salud',                         'report_column_name' => 'RÉGIMEN EPS'],
    'bloodType'                         => ['column_name' => 'nombre_tipo_sangre',                       'table' => 'v_general_datos_salud',                         'report_column_name' => 'TIPO SANGRE'],
    'emergencyContactName'              => ['column_name' => 'nombre_contacto_emergencia',               'table' => 'v_general_datos_salud',                         'report_column_name' => 'NOMBRE CONTACTO EMERGENCIA'],
    'emergencyContactNumber'            => ['column_name' => 'telefono_contacto_emergencia',             'table' => 'v_general_datos_salud',                         'report_column_name' => 'TELÉFONO CONTACTO EMERGENCIA'],
    'alergies'                          => ['column_name' => 'alergias',                                 'table' => 'v_general_datos_salud',                         'report_column_name' => 'ALERGIAS'],
    'disability'                        => ['column_name' => 'nombre_tipo_discapacidad',                 'table' => 'v_general_datos_salud',                         'report_column_name' => 'DISCAPACIDAD'],
    'specialEducationNeeds'             => ['column_name' => 'necesidades_educacion_especial',           'table' => 'v_general_datos_salud',                         'report_column_name' => 'NECESIDADES DE EDUCACIÓN ESPECIAL'],

    'validatedSchool'                   => ['column_name' => 'bachillerato_validado',                    'table' => 'v_general_datos_socioeconomicos',               'report_column_name' => 'BACHILLERATO VALIDADO'],
    'sisbenStratum'                     => ['column_name' => 'estrato_sisben_iv',                        'table' => 'v_general_datos_socioeconomicos',               'report_column_name' => 'NIVEL SISBEN IV'],
    'socieconomicStratum'               => ['column_name' => 'nombre_estrato_socioeconomico',            'table' => 'v_general_datos_socioeconomicos',               'report_column_name' => 'ESTRATO SOCIOECONÓMICO'],
    'ocupation'                         => ['column_name' => 'nombre_ocupacion_aspirante',               'table' => 'v_general_datos_socioeconomicos',               'report_column_name' => 'OCUPACIÓN ASPIRANTE'],

    /*'admissionCriteria'                 => ['column_name' => 'nombre_criterio_admision',                 'table' => 'v_general_datos_socioeconomicos',               'report_column_name' => 'CRITERIO DE ADMISIÓN'],
    'specialGeneralCriteria'            => ['column_name' => 'nombre_criterio_especial_general',         'table' => 'v_general_datos_socioeconomicos',               'report_column_name' => 'CRITERIO ESPECIAL GENERAL'],
    'specialEspecificCriteria'          => ['column_name' => 'nombre_criterio_especial_especifico',      'table' => 'v_general_datos_socioeconomicos',               'report_column_name' => 'CRITERIO ESPECIAL ESPECÍFICO'],*/

    'specialPopulationSpecificType'     => ['column_name' => 'nombre_tipo_poblacion_condicion',          'table' => 'v_general_datos_socioeconomicos',               'report_column_name' => 'POBLACION ESPECIAL ESPECÍFICA'],
    'socialProgram'                     => ['column_name' => 'nombre_programa_social',                   'table' => 'v_general_datos_socioeconomicos',               'report_column_name' => 'PROGRAMA SOCIAL'],
    'ethnicGroup'                       => ['column_name' => 'nombre_grupo_etnico',                      'table' => 'v_general_datos_socioeconomicos',               'report_column_name' => 'GRUPO ETNICO'],
    'finantialHelp'                     => ['column_name' => 'ayuda_financiera',                         'table' => 'v_general_datos_socioeconomicos',               'report_column_name' => 'AYUDA FINANCIERA'],
    'economicHelp'                      => ['column_name' => 'ayuda_economica',                          'table' => 'v_general_datos_socioeconomicos',               'report_column_name' => 'AYUDA ECONÓMICA'],
    'residenceHomeType'                 => ['column_name' => 'nombre_tipo_vivienda_residencia',          'table' => 'v_general_datos_socioeconomicos',               'report_column_name' => 'TIPO DE VIVIENDA DONDE RESIDE'],
    'economicDependency'                => ['column_name' => 'nombre_dependencia_economica',             'table' => 'v_general_datos_socioeconomicos',               'report_column_name' => 'DEPENDENCIA ECONÓMICA'],
    'indigenousCommunity'               => ['column_name' => 'nombre_pueblo_indigena',                   'table' => 'v_general_datos_socioeconomicos',               'report_column_name' => 'PUEBLO INDÍGENA'],
    'blackCommunity'                    => ['column_name' => 'nombre_comunidad_negra',                   'table' => 'v_general_datos_socioeconomicos',               'report_column_name' => 'COMUNIDAD NEGRA'],

    'icfesPresentationDate'             => ['column_name' => 'fecha_presentacion_icfes',                 'table' => 'v_general_otros_datos',                         'report_column_name' => 'FECHA DE PRESENTACIÓN ICFES'],
    'timeTakenToEntry'                  => ['column_name' => 'tiempo_tomo_ingreso_u',                    'table' => 'v_general_otros_datos',                         'report_column_name' => 'TIEMPO TOMADO PARA INGRESAR'],
    'timeTakenToEntryReason'            => ['column_name' => 'motivo_tiempo_ingreso_u',                  'table' => 'v_general_otros_datos',                         'report_column_name' => 'RAZÓN DEL TIEMPO PARA EL INGRESO'],
    'militaryPassport'                  => ['column_name' => 'libreta_militar',                          'table' => 'v_general_otros_datos',                         'report_column_name' => 'LIBRETA MILITAR'],
    'exceptionalCapability'             => ['column_name' => 'nombre_capacidad_excepcional',             'table' => 'v_general_otros_datos',                         'report_column_name' => 'CAPACIDAD EXCEPCIONAL'],
    'dataTreatment'                     => ['column_name' => 'politica_tratamiento_datos',               'table' => 'v_general_otros_datos',                         'report_column_name' => 'TRATAMIENTO DE DATOS'],
    'universitaryCareer'                => ['column_name' => 'carrera_universitaria',                    'table' => 'v_general_otros_datos',                         'report_column_name' => 'CARRERA UNIVERSITARIA'],

    'icfesGlobalScore'                  => ['column_name' => 'puntaje_global_icfes',                     'table' => 'v_puntajes_icfes_por_materia_del_aspirante',    'report_column_name' => 'PUNTAJE GLOBAL ICFES'],
    'icfesMathScore'                    => ['column_name' => 'puntaje_matematicas',                      'table' => 'v_puntajes_icfes_por_materia_del_aspirante',    'report_column_name' => 'PUNTAJE MATEMÁTICAS'],
    'icfesScienceScore'                 => ['column_name' => 'puntaje_ciencias_naturales',               'table' => 'v_puntajes_icfes_por_materia_del_aspirante',    'report_column_name' => 'PUNTAJE CIENCIAS NATURALES'],
    'icfesEnglishScore'                 => ['column_name' => 'puntaje_ingles',                           'table' => 'v_puntajes_icfes_por_materia_del_aspirante',    'report_column_name' => 'PUNTAJE INGLÉS'],
    'icfesCriticReadingScore'           => ['column_name' => 'puntaje_lectura_critica',                  'table' => 'v_puntajes_icfes_por_materia_del_aspirante',    'report_column_name' => 'PUNTAJE LECTURA CRÍTICA'],
    'icfesSocialSciencesScore'          => ['column_name' => 'puntaje_ciencias_sociales_y_ciudadanas',   'table' => 'v_puntajes_icfes_por_materia_del_aspirante',    'report_column_name' => 'PUNTAJE CIENCIAS SOCIALES Y CIUDADANAS'],
    'admissionScore'                    => ['column_name' => 'resultado_admision',                       'table' => 'v_puntajes_icfes_por_materia_del_aspirante',    'report_column_name' => 'PUNTAJE OBTENIDO EN LA ADMISIÓN'],
];

$filters = [
    'academic_period_filter'    => 'codigo_periodo_academico',
    'academic_program_filter'   => 'codigo_programa_academico',
    'procedure_state_filter'    => 'codigo_estado_procedimiento',
    'study_level_filter'        => 'codigo_nivel_estudio',
    'facultie_filter'           => 'codigo_facultad'
];
