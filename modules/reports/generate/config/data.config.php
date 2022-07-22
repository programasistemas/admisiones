<?php

$select_styles = 'form-select mt-2';
$filters_html_data = [
    [
        [
            'id' => 'academic_period_filter',
            'data' => $periods,
            'custom_style' => $select_styles,
            'select_title' => 'Seleccione un periodo académico',
            'filter_title' => 'Periodo académico',
            'icon_class' => 'fas fa-calendar-week'
        ],
        [
            'id' => 'academic_program_filter',
            'data' => $programs,
            'custom_style' => $select_styles,
            'select_title' => 'Seleccione un programa académico',
            'filter_title' => 'Programa académico',
            'icon_class' => 'fas fa-graduation-cap'
        ],
        [
            'id' => 'procedure_state_filter',
            'data' => $states,
            'custom_style' => $select_styles,
            'select_title' => 'Selecciona un estado',
            'filter_title' => 'Estado del procedimiento',
            'icon_class' => 'fas fa-battery-three-quarters'
        ]

    ], [
        [
            'id' => 'study_level_filter',
            'data' => $study_levels,
            'custom_style' => $select_styles,
            'select_title' => 'Seleccione un nivel de estudio',
            'filter_title' => 'Nivel de estudio',
            'icon_class' => 'fas fa-level-up-alt'
        ],
        [
            'id' => 'facultie_filter',
            'data' => $faculties,
            'custom_style' => $select_styles,
            'select_title' => 'Seleccione una facultad',
            'filter_title' => 'Facultad',
            'icon_class' => 'fas fa-university'
        ]
    ]
];

$fields = [
    [
        'itemName' => 'Datos básicos',
        'itemId' => 'basic_data',
        'content' => [
            ['id' => 'firstName', 'placeholder' => 'Primer nombre'],
            ['id' => 'secondName', 'placeholder' => 'Segundo nombre'],
            ['id' => 'firstSurname', 'placeholder' => 'Primer apellido'],
            ['id' => 'secondSurname', 'placeholder' => 'Segundo apellido'],
            ['id' => 'age', 'placeholder' => 'Edad'],
            ['id' => 'icfesCode', 'placeholder' => 'AC Icfes'],
            ['id' => 'regionalization', 'placeholder' => 'Regionalización'],
            ['id' => 'birthDate', 'placeholder' => 'Fecha de nacimiento'],
            ['id' => 'biologicalSex', 'placeholder' => 'Sexo'],
            ['id' => 'documentExpeditionDate', 'placeholder' => 'Fecha de expedición de documento'],
            ['id' => 'documentExpeditionTown', 'placeholder' => 'Municipio de expedición de documento'],
            ['id' => 'documentExpeditionDepartment', 'placeholder' => 'Departamento de expedición de documento'],
            ['id' => 'academicProgram', 'placeholder' => 'Programa académico'],
            ['id' => 'birthTown', 'placeholder' => 'Municipio/ciudad de nacimiento'],
            ['id' => 'birthDepartment', 'placeholder' => 'Departamento de nacimiento'],
            ['id' => 'studyLevel', 'placeholder' => 'Nivel de estudio'],
            ['id' => 'facultyName', 'placeholder' => 'Facultad'],
            ['id' => 'procedenceTown', 'placeholder' => 'Municipio/ciudad de procedencia'],
            ['id' => 'procedenceDepartment', 'placeholder' => 'Departamento de procedencia'],
            ['id' => 'graduatedSchool', 'placeholder' => 'Colegio egresado'],
            ['id' => 'graduatedSchoolDANECode', 'placeholder' => 'Código DANE colegio egresado'],
            ['id' => 'graduatedSchoolTown', 'placeholder' => 'Municipio/ciudad colegio egresado']
        ]
    ],
    [
        'itemName' => 'Datos de residencia',
        'itemId' => 'residence_data',
        'content' => [
            ['id' => 'residenceTown', 'placeholder' => 'Municipio de residencia'],
            ['id' => 'residenceDepartment', 'placeholder' => 'Departamento de residencia'],
            ['id' => 'residenceNeighbourhood', 'placeholder' => 'Barrio de residencia'],
            ['id' => 'residenceDirection', 'placeholder' => 'Dirección de residencia'],
            ['id' => 'residenceZone', 'placeholder' => 'Zona de residencia']
        ]
    ],
    [
        'itemName' => 'Datos familiares',
        'itemId' => 'familiar_data',
        'content' => [
            ['id' => 'studyLevelFather', 'placeholder' => 'Nivel de estudio del padre'],
            ['id' => 'studyLevelMother', 'placeholder' => 'Nivel de estudio de la madre'],
            ['id' => 'children', 'placeholder' => 'Número de hijos']
        ]
    ],
    [
        'itemName' => 'Datos de salud',
        'itemId' => 'health_data',
        'content' => [
            ['id' => 'eps', 'placeholder' => 'EPS'],
            ['id' => 'epsRegimen', 'placeholder' => 'Régimen de EPS'],
            ['id' => 'bloodType', 'placeholder' => 'Tipo de sangre'],
            ['id' => 'emergencyContactName', 'placeholder' => 'Nombre del contacto de emergencia'],
            ['id' => 'emergencyContactNumber', 'placeholder' => 'Número telefónico del contacto de emergencia'],
            ['id' => 'alergies', 'placeholder' => 'Alergias'],
            ['id' => 'disability', 'placeholder' => 'Discapacidad'],
            ['id' => 'specialEducationNeeds', 'placeholder' => 'Necesidades de educación especial']
        ]
    ],
    [
        'itemName' => 'Datos socioeconómicos',
        'itemId' => 'socieconomic_data',
        'content' => [
            ['id' => 'validatedSchool', 'placeholder' => 'Bachillerato validado'],
            ['id' => 'sisbenStratum', 'placeholder' => 'Estrato de Sisben IV'],
            ['id' => 'socieconomicStratum', 'placeholder' => 'Estrato socioeconómico'],
            ['id' => 'ocupation', 'placeholder' => 'Ocupación'],
            ['id' => 'specialPopulationSpecificType', 'placeholder' => 'Tipo de población especial específica'],
            ['id' => 'socialProgram', 'placeholder' => 'Programa social'],
            ['id' => 'ethnicGroup', 'placeholder' => 'Grupo étnico'],
            ['id' => 'finantialHelp', 'placeholder' => 'Ayuda financiera'],
            ['id' => 'economicHelp', 'placeholder' => 'Ayuda económica'],
            ['id' => 'residenceHomeType', 'placeholder' => 'Tipo de vivienda donde reside'],
            ['id' => 'economicDependency', 'placeholder' => 'Dependencia económica'],
            ['id' => 'indigenousCommunity', 'placeholder' => 'Pueblo indígena'],
            ['id' => 'blackCommunity', 'placeholder' => 'Comunidad negra']
        ]
    ],
    [
        'itemName' => 'Otros datos',
        'itemId' => 'other_data',
        'content' => [
            ['id' => 'icfesPresentationDate', 'placeholder' => 'Fecha de presentación ICFES'],
            ['id' => 'timeTakenToEntry', 'placeholder' => 'Tiempo tomado para ingreso'],
            ['id' => 'timeTakenToEntryReason', 'placeholder' => 'Motivo del tiempo de ingreso'],
            ['id' => 'militaryPassport', 'placeholder' => 'Libreta militar'],
            ['id' => 'exceptionalCapability', 'placeholder' => 'Capacidad excepcional'],
            ['id' => 'dataTreatment', 'placeholder' => 'Tratamiento de datos'],
            ['id' => 'universitaryCareer', 'placeholder' => 'Carrera universitaria'],
            ['id' => 'icfesGlobalScore', 'placeholder' => 'Puntaje global ICFES'],
            ['id' => 'icfesMathScore', 'placeholder' => 'Puntaje matemáticas ICFES'],
            ['id' => 'icfesScienceScore', 'placeholder' => 'Puntaje ciencias naturales ICFES'],
            ['id' => 'icfesEnglishScore', 'placeholder' => 'Puntaje inglés ICFES'],
            ['id' => 'icfesCriticReadingScore', 'placeholder' => 'Puntaje lectura crítica ICFES'],
            ['id' => 'icfesSocialSciencesScore', 'placeholder' => 'Puntaje ciencias sociales ICFES'],
            ['id' => 'admissionScore', 'placeholder' => 'Puntaje obtenido en la admisión']
        ]
    ]
];
