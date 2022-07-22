<?php

/**
 * Get the permissiones array based on the user type
 * @param int $user_type Session user type
 * @return array Array with the permissions
 */
function getUserPermissions($user_type)
{
    $permissions =  [
        1 => ['ADMIN', 'VALIDATOR', 'DASHBOARD', 'CALIFICATION_POS', 'TREASURY_REPORT', 'REPORTS_GENERATION'],   //  SUPERUSUARIO
        2 => ['ADMIN', 'VALIDATOR', 'DASHBOARD', 'CALIFICATION_POS', 'TREASURY_REPORT', 'REPORTS_GENERATION'],   //  ADMINISTRADOR
        3 => ['VALIDATOR'],                                             //  VALIDADOR
        4 => ['STUDENT'],                                               //  ESTUDIANTE
        5 => ['DASHBOARD', 'REPORTS_GENERATION'],                       //  JEFE DE PROGRAMA
        6 => ['DASHBOARD', 'REPORTS_GENERATION'],                       //  VICERRECTOR
        7 => ['TREASURY_REPORT'],                                       //  ADMINISTRATIVO
        8 => ['DASHBOARD'],                                             //  RECTOR
        9 => ['CALIFICATION_POS'],                                      //  VALIDADOR POSGRADO
    ];

    return $permissions[$user_type];
}
