<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Rubrica.
 *
 * @property int $id
 * @property string|null $nome
 * @property string|null $cognome
 * @property string|null $secondo_nome
 * @property string|null $nome_e_cognome
 * @property string|null $alternativo
 * @property string|null $posta_elettronica
 * @property string|null $via_ab
 * @property string|null $citta_ab
 * @property string|null $cap_ab
 * @property string|null $provincia_ab
 * @property string|null $paese_ab
 * @property string|null $telefono_ab
 * @property string|null $fax_ab
 * @property string|null $cellulare
 * @property string|null $pagina_web_personale
 * @property string|null $via_uff
 * @property string|null $citta_uff
 * @property string|null $cap_uff
 * @property string|null $provincia_uff
 * @property string|null $paese_uff
 * @property string|null $pagina_web_professionale
 * @property string|null $telefono_uff
 * @property string|null $fax_uff
 * @property string|null $cercapersone
 * @property string|null $societa
 * @property string|null $posizione
 * @property string|null $reparto
 * @property string|null $ufficio
 * @property string|null $note
 *
 * @method static Builder|Rubrica newModelQuery()
 * @method static Builder|Rubrica newQuery()
 * @method static Builder|Rubrica query()
 * @method static Builder|Rubrica whereAlternativo($value)
 * @method static Builder|Rubrica whereCapAb($value)
 * @method static Builder|Rubrica whereCapUff($value)
 * @method static Builder|Rubrica whereCellulare($value)
 * @method static Builder|Rubrica whereCercapersone($value)
 * @method static Builder|Rubrica whereCittaAb($value)
 * @method static Builder|Rubrica whereCittaUff($value)
 * @method static Builder|Rubrica whereCognome($value)
 * @method static Builder|Rubrica whereFaxAb($value)
 * @method static Builder|Rubrica whereFaxUff($value)
 * @method static Builder|Rubrica whereId($value)
 * @method static Builder|Rubrica whereNome($value)
 * @method static Builder|Rubrica whereNomeECognome($value)
 * @method static Builder|Rubrica whereNote($value)
 * @method static Builder|Rubrica wherePaeseAb($value)
 * @method static Builder|Rubrica wherePaeseUff($value)
 * @method static Builder|Rubrica wherePaginaWebPersonale($value)
 * @method static Builder|Rubrica wherePaginaWebProfessionale($value)
 * @method static Builder|Rubrica wherePosizione($value)
 * @method static Builder|Rubrica wherePostaElettronica($value)
 * @method static Builder|Rubrica whereProvinciaAb($value)
 * @method static Builder|Rubrica whereProvinciaUff($value)
 * @method static Builder|Rubrica whereReparto($value)
 * @method static Builder|Rubrica whereSecondoNome($value)
 * @method static Builder|Rubrica whereSocieta($value)
 * @method static Builder|Rubrica whereTelefonoAb($value)
 * @method static Builder|Rubrica whereTelefonoUff($value)
 * @method static Builder|Rubrica whereUfficio($value)
 * @method static Builder|Rubrica whereViaAb($value)
 * @method static Builder|Rubrica whereViaUff($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\RubricaFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Rubrica extends BaseModel
{
    protected $table = 'rubrica';
}
