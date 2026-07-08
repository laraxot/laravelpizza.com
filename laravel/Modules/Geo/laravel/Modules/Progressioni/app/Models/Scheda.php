<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Route;
use InvalidArgumentException;
use Modules\Performance\Models\Individuale;
use Modules\Progressioni\Database\Factories\SchedaFactory;
use Modules\Progressioni\Models\Traits\ProgressioniTrait;
use Modules\Ptv\Models\BaseScheda;
use Modules\Ptv\Models\Profile;
use Modules\Sigma\Actions\MassUpdateCategoriaEcoAction;
use Modules\Sigma\Actions\MassUpdateCognomeNomeAction;
use Modules\Sigma\Actions\MassUpdatePosizTxtAction;
use Modules\Sigma\Actions\MassUpdateStabiTxtReparTxtAction;
use Modules\Sigma\Datas\GgFilterData;
use Modules\Sigma\Models\Ana02f;
use Modules\Sigma\Models\Ana10f;
use Modules\Sigma\Models\Anag;
use Modules\Sigma\Models\Asz00f;
use Modules\Sigma\Models\Asz00k1;
use Modules\Sigma\Models\Integparam;
use Modules\Sigma\Models\Qua00f;
use Modules\Sigma\Models\Qua03f;
use Modules\Sigma\Models\Rep00f;
use Modules\Sigma\Models\Repart;
use Modules\Sigma\Models\Sto00f;
use Modules\Sigma\Models\Tqu00f;
use Modules\Sigma\Models\Wstr01lx;
use Modules\Xot\Services\HtmlService;
use RuntimeException;

/**
 * Modules\Progressioni\Models\Scheda.
 *
 * @property int $id
 * @property string $post_type
 * @property string|null $scheda_type
 * @property int|null $ente
 * @property int|null $matr
 * @property string|null $cognome
 * @property string|null $nome
 * @property string|null $email
 * @property int|null $propro
 * @property int|null $posfun
 * @property string|null $categoria_eco
 * @property int|null $posiz
 * @property string|null $posiz_txt
 * @property int|null $clafun
 * @property int|null $stabi
 * @property string|null $stabi_txt
 * @property int|null $repar
 * @property string|null $repar_txt
 * @property int|null $stabival
 * @property int|null $reparval
 * @property string|null $indir
 * @property int|null $gg_in_sede
 * @property int|null $n_gg_in_sede
 * @property int|null $gg_fuori_sede
 * @property int|null $n_gg_fuori_sede
 * @property int|null $gg_aspettative_in_sede
 * @property int|null $gg_aspettative_fuori_sede
 * @property int|null $gg_posiz_1_in_sede
 * @property int|null $gg_presenza_anno
 * @property int|null $gg_assenza_anno
 * @property int|null $gg_asz_tip_cod_escluso_subito
 * @property int|null $gg_anno
 * @property int|null $gg_cateco_posfun
 * @property int|null $rep003
 * @property int|null $disci1
 * @property string|null $disci1_txt
 * @property int|null $rep2kd
 * @property int|null $rep2ka
 * @property int|null $qua2kd
 * @property int|null $qua2ka
 * @property int|null $dal
 * @property int|null $al
 * @property int|null $gg
 * @property int|null $anno
 * @property string|null $esperienza_acquisita
 * @property int|null $peso_esperienza_acquisita
 * @property string|null $risultati_ottenuti
 * @property string|null $peso_risultati_ottenuti
 * @property string|null $arricchimento_professionale
 * @property string|null $peso_arricchimento_professionale
 * @property string|null $impegno
 * @property string|null $peso_impegno
 * @property string|null $qualita_prestazione
 * @property string|null $peso_qualita_prestazione
 * @property string|null $totale
 * @property float|null $totale_pond se ha fatto piu' stabi
 * @property int|null $ha_diritto
 * @property string|null $motivo
 * @property string|null $gg_aspettative_pond_in_sede
 * @property string|null $gg_aspettative_pond_fuori_sede
 * @property string|null $categoria_ecoval
 * @property int $posfunval
 * @property int|null $gg_cateco_in_sede
 * @property int|null $gg_cateco_fuori_sede
 * @property int|null $gg_cateco_posfun_in_sede
 * @property int|null $gg_cateco_posfun_fuori_sede
 * @property int|null $gg_cateco_no_posfun_in_sede
 * @property int|null $gg_cateco_no_posfun_fuori_sede
 * @property int|null $gg_no_cateco_in_sede
 * @property int|null $gg_no_cateco_fuori_sede
 * @property int|null $gg_no_cateco_posfun_in_sede
 * @property int|null $gg_no_cateco_posfun_fuori_sede
 * @property int|null $gg_asz_cateco_posfun_in_sede
 * @property int|null $gg_asz_cateco_posfun_fuori_sede
 * @property string|null $gg_tot_pond
 * @property int|null $asz2ka
 * @property int|null $gg_presenze_in_anno
 * @property int|null $gg_assenze_in_anno
 * @property int|null $ore_assenze_in_anno
 * @property int|null $benificiario_progressione
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property string|null $deleted_ip
 * @property string|null $created_ip
 * @property string|null $updated_ip
 * @property int|null $vincitore
 * @property string|null $perf_ind_2015
 * @property string|null $perf_ind_2016
 * @property string|null $perf_ind_2017
 * @property string|null $perf_ind_2018
 * @property string|null $perf_ind_2014
 * @property float|null $perf_ind_media
 * @property string|null $peso_perf_ind_media
 * @property string|null $risultato
 * @property float|null $ptime
 * @property float|null $costo_fascia_up
 * @property int|null $valutatore_id
 * @property string|null $titolo_di_studio
 * @property string|null $lang
 * @property int|null $punt_progressione
 * @property float|null $punt_progressione_finale
 * @property int|null $gg_cateco_posfun_no_asz
 * @property int|null $gg_cateco_posfun_in_sede_no_asz
 * @property int|null $gg_ruolo
 * @property int|null $gg_presenza_anno
 * @property int|null $gg_assenza_anno
 * @property string|null $perf_ind_2019
 * @property int|null $gg_asz
 * @property int|null $hh_asz
 * @property int|null $gg_cateco_sup_in_sede
 * @property int|null $propro
 * @property int|null $posiz
 * @property int|null $posfun
 * @property int|null $disci1
 * @property string|null $last_data_assunz
 * @property int|null $excellences_count_last_3_years
 * @property int|null $perf_ind_count_last_3_years
 * @property string|null $perf_ind_2020
 * @property float|null $eta
 * @property float|null $gg_in_sede_no_asz
 * @property float|null $valore_differenziale_rapportato_pt
 * @property string $perf_ind_2021
 * @property Collection<int, Sto00f> $Sto00fYear
 * @property int|null $sto00f_year_count
 * @property Collection<int, Ana02f> $ana02f
 * @property int|null $ana02f_count
 * @property Ana10f|null $ana10f
 * @property Anag|null $anag
 * @property Collection<int, Assenza> $assenze
 * @property int|null $assenze_count
 * @property Collection<int, Asz00k1> $asz
 * @property int|null $asz_count
 * @property Collection<int, Asz00f> $asz00f
 * @property int|null $asz00f_count
 * @property Collection<int, Asz00f> $asz00fs
 * @property int|null $asz00fs_count
 * @property Collection<int, Asz00k1> $asz00k1
 * @property int|null $asz00k1_count
 * @property Collection<int, Asz00k1> $asz00k1Year
 * @property int|null $asz00k1_year_count
 * @property Collection<int, Scheda> $avversari
 * @property int|null $avversari_count
 * @property Collection<int, Scheda> $avversariCategoriaEco
 * @property int|null $avversari_categoria_eco_count
 * @property CategoriaPropro|null $categoriaPropro
 * @property Collection<int, Coeff> $coeff
 * @property int|null $coeff_count
 * @property Collection<int, CriteriEsclusione> $criteriEsclusione
 * @property int|null $criteri_esclusione_count
 * @property Collection<int, CriteriOption> $criteriOptions
 * @property int|null $criteri_options_count
 * @property Collection<int, CriteriPrecedenza> $criteriPrecedenza
 * @property int|null $criteri_precedenza_count
 * @property Collection<int, CriteriValutazione> $criteriValutazione
 * @property int|null $criteri_valutazione_count
 * @property EsclusiExtra|null $esclusoExtra
 * @property mixed $aventi_diritto
 * @property mixed $aventi_diritto_eff
 * @property mixed $codqua
 * @property mixed $cont
 * @property int|null $excellences_count_last3years
 * @property int|null $gg_asz_cateco_posfun
 * @property int|null $gg_asz_fuori_sede
 * @property int|null $gg_asz_in_sede
 * @property float $gg_cateco_posfun_rapportato_max10_valutatore
 * @property int|float $gg_p_time_vert_year
 * @property mixed $gg_parttimevert_anno
 * @property int|null $gg_parttimevert
 * @property mixed $gg_parttimevert_dalal
 * @property int|null $gg_posiz1_in_sede
 * @property mixed $gg_presenza_dalal
 * @property int|null $hh_asz_fuori_sede
 * @property int|null $hh_asz_in_sede
 * @property float|null $importo_stipendio_annuo
 * @property mixed $last_data_assunz
 * @property string|null $lista_propro
 * @property string|null $lista_propro_sup
 * @property int|float $perc_p_time_daterange
 * @property int|float $perc_p_time_year
 * @property mixed $perc_parttime_anno
 * @property float|null $perc_parttime
 * @property mixed $perc_parttime_dalal
 * @property float|null $perc_parttimepond_anno
 * @property mixed $perc_parttimepond_dalal
 * @property float|null $perf_ind2014
 * @property float|null $perf_ind2015
 * @property float|null $perf_ind2016
 * @property float|null $perf_ind2017
 * @property float|null $perf_ind2018
 * @property float|null $perf_ind2019
 * @property float|null $perf_ind2020
 * @property float|null $perf_ind2021
 * @property float|null $perf_ind2022
 * @property float|null $perf_ind2023
 * @property float|null $perf_ind2024
 * @property void $perf_ind_avg_last3_years
 * @property int|null $perf_ind_count_last3_years
 * @property int $posizione
 * @property string|null $posizione_eco
 * @property mixed $tipco
 * @property string|null $valutatore_txt
 * @property Collection<int, MyLog> $mailInviate
 * @property int|null $mail_inviate_count
 * @property Collection<int, Scheda> $mails
 * @property int|null $mails_count
 * @property MaxCatecoPosfunAnno|null $maxCatecoPosfun
 * @property Collection<int, Message> $messages
 * @property int|null $messages_count
 * @property Collection<int, MyLog> $myLogs
 * @property int|null $my_logs_count
 * @property Collection<int, Individuale> $performanceIndividuale
 * @property int|null $performance_individuale_count
 * @property Pesi|null $pesi
 * @property Collection<int, Qua00f> $qua00f
 * @property int|null $qua00f_count
 * @property Collection<int, Qua00f> $qua00fDaterange
 * @property int|null $qua00f_daterange_count
 * @property Collection<int, Qua00f> $qua00fYear
 * @property int|null $qua00f_year_count
 * @property Collection<int, Qua03f> $qua03f
 * @property int|null $qua03f_count
 * @property Collection<int, Rep00f> $rep00f
 * @property int|null $rep00f_count
 * @property Collection<int, Repart> $reparts
 * @property int|null $reparts_count
 * @property Collection<int, Scheda> $righeDoppie
 * @property int|null $righe_doppie_count
 * @property Collection<int, SchedaCriteri> $schedaCriteri
 * @property int|null $scheda_criteri_count
 * @property StabiDirigente|null $stabiDirigente
 * @property StipendioTabellare|null $stipendioTabellare
 * @property StipendioTabellare|null $stipendioTabellareUp
 * @property Collection<int, Sto00f> $sto00f
 * @property int|null $sto00f_count
 * @property Tqu00f|null $tqu00f
 * @property StabiDirigente|null $valutatore
 * @property StabiDirigente|null $valutatoreDefault
 * @property Collection<int, Wstr01lx> $wstr01lx
 * @property int|null $wstr01lx_count
 * @property Collection<int, Wstr01lx> $wstr01lxYear
 * @property int|null $wstr01lx_year_count
 *
 * @method static SchedaFactory factory($count = null, $state = [])
 * @method static Builder|Scheda newModelQuery()
 * @method static Builder|Scheda newQuery()
 * @method static Builder|Scheda ofDate(int $date)
 * @method static Builder|Scheda ofEnteYear(int $ente, int $year)
 * @method static Builder|Scheda ofQuarter(int $quarter, int $year)
 * @method static Builder|Scheda ofRangeDate(int $date_start, int $date_end)
 * @method static Builder|Scheda ofYear(int $year)
 * @method static Builder|Scheda query()
 * @method static Builder|Scheda whereAl($value)
 * @method static Builder|Scheda whereAnno($value)
 * @method static Builder|Scheda whereArricchimentoProfessionale($value)
 * @method static Builder|Scheda whereAsz2ka($value)
 * @method static Builder|Scheda whereBenificiarioProgressione($value)
 * @method static Builder|Scheda whereCategoriaEco($value)
 * @method static Builder|Scheda whereCategoriaEcoval($value)
 * @method static Builder|Scheda whereClafun($value)
 * @method static Builder|Scheda whereCognome($value)
 * @method static Builder|Scheda whereCostoFasciaUp($value)
 * @method static Builder|Scheda whereCreatedAt($value)
 * @method static Builder|Scheda whereCreatedBy($value)
 * @method static Builder|Scheda whereCreatedIp($value)
 * @method static Builder|Scheda whereDal($value)
 * @method static Builder|Scheda whereDeletedAt($value)
 * @method static Builder|Scheda whereDeletedBy($value)
 * @method static Builder|Scheda whereDeletedIp($value)
 * @method static Builder|Scheda whereDisci1($value)
 * @method static Builder|Scheda whereDisci1Txt($value)
 * @method static Builder|Scheda whereEmail($value)
 * @method static Builder|Scheda whereEnte($value)
 * @method static Builder|Scheda whereEsperienzaAcquisita($value)
 * @method static Builder|Scheda whereEta($value)
 * @method static Builder|Scheda whereExcellencesCountLast3Years($value)
 * @method static Builder|Scheda whereGg($value)
 * @method static Builder|Scheda whereGgAnno($value)
 * @method static Builder|Scheda whereGgAspettativeFuoriSede($value)
 * @method static Builder|Scheda whereGgAspettativeInSede($value)
 * @method static Builder|Scheda whereGgAspettativePondFuoriSede($value)
 * @method static Builder|Scheda whereGgAspettativePondInSede($value)
 * @method static Builder|Scheda whereGgAssenzaAnno($value)
 * @method static Builder|Scheda whereGgAssenzeInAnno($value)
 * @method static Builder|Scheda whereGgAsz($value)
 * @method static Builder|Scheda whereGgAszCatecoPosfunFuoriSede($value)
 * @method static Builder|Scheda whereGgAszCatecoPosfunInSede($value)
 * @method static Builder|Scheda whereGgAszTipCodEsclusoSubito($value)
 * @method static Builder|Scheda whereGgCatecoFuoriSede($value)
 * @method static Builder|Scheda whereGgCatecoInSede($value)
 * @method static Builder|Scheda whereGgCatecoNoPosfunFuoriSede($value)
 * @method static Builder|Scheda whereGgCatecoNoPosfunInSede($value)
 * @method static Builder|Scheda whereGgCatecoPosfun($value)
 * @method static Builder|Scheda whereGgCatecoPosfunFuoriSede($value)
 * @method static Builder|Scheda whereGgCatecoPosfunInSede($value)
 * @method static Builder|Scheda whereGgCatecoPosfunInSedeNoAsz($value)
 * @method static Builder|Scheda whereGgCatecoPosfunNoAsz($value)
 * @method static Builder|Scheda whereGgCatecoSupInSede($value)
 * @method static Builder|Scheda whereGgFuoriSede($value)
 * @method static Builder|Scheda whereGgInSede($value)
 * @method static Builder|Scheda whereGgInSedeNoAsz($value)
 * @method static Builder|Scheda whereGgNoCatecoFuoriSede($value)
 * @method static Builder|Scheda whereGgNoCatecoInSede($value)
 * @method static Builder|Scheda whereGgNoCatecoPosfunFuoriSede($value)
 * @method static Builder|Scheda whereGgNoCatecoPosfunInSede($value)
 * @method static Builder|Scheda whereGgPosiz1InSede($value)
 * @method static Builder|Scheda whereGgPresenzaAnno($value)
 * @method static Builder|Scheda whereGgPresenzeInAnno($value)
 * @method static Builder|Scheda whereGgTotPond($value)
 * @method static Builder|Scheda whereHaDiritto($value)
 * @method static Builder|Scheda whereHhAsz($value)
 * @method static Builder|Scheda whereId($value)
 * @method static Builder|Scheda whereImpegno($value)
 * @method static Builder|Scheda whereIndir($value)
 * @method static Builder|Scheda whereLang($value)
 * @method static Builder|Scheda whereMatr($value)
 * @method static Builder|Scheda whereMotivo($value)
 * @method static Builder|Scheda whereNGgFuoriSede($value)
 * @method static Builder|Scheda whereNGgInSede($value)
 * @method static Builder|Scheda whereNome($value)
 * @method static Builder|Scheda whereOreAssenzeInAnno($value)
 * @method static Builder|Scheda wherePerfInd2014($value)
 * @method static Builder|Scheda wherePerfInd2015($value)
 * @method static Builder|Scheda wherePerfInd2016($value)
 * @method static Builder|Scheda wherePerfInd2017($value)
 * @method static Builder|Scheda wherePerfInd2018($value)
 * @method static Builder|Scheda wherePerfInd2019($value)
 * @method static Builder|Scheda wherePerfInd2020($value)
 * @method static Builder|Scheda wherePerfInd2021($value)
 * @method static Builder|Scheda wherePerfIndCountLast3Years($value)
 * @method static Builder|Scheda wherePerfIndMedia($value)
 * @method static Builder|Scheda wherePesoArricchimentoProfessionale($value)
 * @method static Builder|Scheda wherePesoEsperienzaAcquisita($value)
 * @method static Builder|Scheda wherePesoImpegno($value)
 * @method static Builder|Scheda wherePesoPerfIndMedia($value)
 * @method static Builder|Scheda wherePesoQualitaPrestazione($value)
 * @method static Builder|Scheda wherePesoRisultatiOttenuti($value)
 * @method static Builder|Scheda wherePosfun($value)
 * @method static Builder|Scheda wherePosfunval($value)
 * @method static Builder|Scheda wherePosiz($value)
 * @method static Builder|Scheda wherePosizTxt($value)
 * @method static Builder|Scheda wherePostType($value)
 * @method static Builder|Scheda wherePropro($value)
 * @method static Builder|Scheda wherePtime($value)
 * @method static Builder|Scheda wherePuntProgressione($value)
 * @method static Builder|Scheda wherePuntProgressioneFinale($value)
 * @method static Builder|Scheda whereQua2ka($value)
 * @method static Builder|Scheda whereQua2kd($value)
 * @method static Builder|Scheda whereQualitaPrestazione($value)
 * @method static Builder|Scheda whereRep003($value)
 * @method static Builder|Scheda whereRep2ka($value)
 * @method static Builder|Scheda whereRep2kd($value)
 * @method static Builder|Scheda whereRepar($value)
 * @method static Builder|Scheda whereReparTxt($value)
 * @method static Builder|Scheda whereReparval($value)
 * @method static Builder|Scheda whereRisultatiOttenuti($value)
 * @method static Builder|Scheda whereRisultato($value)
 * @method static Builder|Scheda whereSchedaType($value)
 * @method static Builder|Scheda whereStabi($value)
 * @method static Builder|Scheda whereStabiTxt($value)
 * @method static Builder|Scheda whereStabival($value)
 * @method static Builder|Scheda whereTitoloDiStudio($value)
 * @method static Builder|Scheda whereTotale($value)
 * @method static Builder|Scheda whereTotalePond($value)
 * @method static Builder|Scheda whereUpdatedAt($value)
 * @method static Builder|Scheda whereUpdatedBy($value)
 * @method static Builder|Scheda whereUpdatedIp($value)
 * @method static Builder|Scheda whereValoreDifferenzialeRapportatoPt($value)
 * @method static Builder|Scheda whereValutatoreId($value)
 * @method static Builder|Scheda whereVincitore($value)
 * @method static Builder|Scheda withDays(int $date_min, int $date_max)
 *
 * @property int|null $gg_cateco
 * @property float|null $gg_no_asz
 * @property int|null $gg_cateco_no_posfun_no_asz
 * @property float|null $gg_fuori_sede_no_asz
 * @property int|null $gg_asz_cateco_in_sede
 * @property int|null $gg_asz_cateco_fuori_sede
 * @property int $gg_asz_cateco
 * @property int|null $gg_cateco_no_asz
 * @property numeric|null $perf_ind_2024
 * @property numeric|null $perf_ind_2025
 * @property numeric|null $perf_ind_2026
 * @property numeric|null $perf_ind_2027
 * @property numeric|null $perf_ind_2028
 * @property numeric|null $perf_ind_2029
 * @property numeric|null $perf_ind_2030
 * @property numeric $perf_ind_2022
 * @property numeric $perf_ind_-1
 * @property numeric $perf_ind_-2
 * @property numeric $perf_ind_-3
 * @property numeric $perf_ind_2023
 * @property string|null $refreshed_at
 * @property int|null $gg_integ_params
 * @property int|null $gg_esperienza_no_asz
 * @property float|null $gg_integ_params_asz
 * @property-read Collection<int, Asz00k1> $aszEff
 * @property-read int|null $asz_eff_count
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read string|null $codice_fiscale
 * @property-read string $from_field
 * @property-read int|null $gg_cateco_sup
 * @property-read int|null $gg_cateco_sup_fuori_sede
 * @property-read string|null $inail
 * @property-read float|null $perf_ind2025
 * @property-read float|null $perf_ind2026
 * @property-read float|null $perf_ind2027
 * @property-read float|null $perf_ind2028
 * @property-read float|null $perf_ind2029
 * @property-read float|null $perf_ind2030
 * @property-read string|null $sesso
 * @property-read string $to_field
 * @property-read Collection<int, Integparam> $integParams
 * @property-read int|null $integ_params_count
 * @property-read Profile|null $updater
 *
 * @method static Builder<static>|Scheda ofEnte(int $ente)
 * @method static Builder<static>|Scheda ofFourMonthPeriod(int $fourMonthPeriod, int $year)
 * @method static Builder<static>|Scheda whereGgAszCateco($value)
 * @method static Builder<static>|Scheda whereGgAszCatecoFuoriSede($value)
 * @method static Builder<static>|Scheda whereGgAszCatecoInSede($value)
 * @method static Builder<static>|Scheda whereGgAszInSede($value)
 * @method static Builder<static>|Scheda whereGgCateco($value)
 * @method static Builder<static>|Scheda whereGgCatecoNoAsz($value)
 * @method static Builder<static>|Scheda whereGgCatecoNoPosfunNoAsz($value)
 * @method static Builder<static>|Scheda whereGgEsperienzaNoAsz($value)
 * @method static Builder<static>|Scheda whereGgFuoriSedeNoAsz($value)
 * @method static Builder<static>|Scheda whereGgIntegParams($value)
 * @method static Builder<static>|Scheda whereGgIntegParamsAsz($value)
 * @method static Builder<static>|Scheda whereGgNoAsz($value)
 * @method static Builder<static>|Scheda whereHhAszInSede($value)
 * @method static Builder<static>|Scheda wherePerfInd1($value)
 * @method static Builder<static>|Scheda wherePerfInd2($value)
 * @method static Builder<static>|Scheda wherePerfInd2022($value)
 * @method static Builder<static>|Scheda wherePerfInd2023($value)
 * @method static Builder<static>|Scheda wherePerfInd2024($value)
 * @method static Builder<static>|Scheda wherePerfInd2025($value)
 * @method static Builder<static>|Scheda wherePerfInd2026($value)
 * @method static Builder<static>|Scheda wherePerfInd2027($value)
 * @method static Builder<static>|Scheda wherePerfInd2028($value)
 * @method static Builder<static>|Scheda wherePerfInd2029($value)
 * @method static Builder<static>|Scheda wherePerfInd2030($value)
 * @method static Builder<static>|Scheda wherePerfInd3($value)
 * @method static Builder<static>|Scheda whereRefreshedAt($value)
 *
 * @mixin \Eloquent
 */
class Scheda extends BaseScheda
{
    use ProgressioniTrait;

    protected $connection = 'progressione';

    protected $table = 'schede';

    /** @var array<int, string> */ public array $valutaz_fields = ['esperienza_acquisita', 'risultati_ottenuti',
        'arricchimento_professionale', 'impegno', 'qualita_prestazione', ];

    /** @var array<int, string> */ public array $xls_fields = ['ente', 'matr', 'cognome', 'nome', 'propro', 'posfun', 'categoria_ecoval', 'posfunval', 'stabi', 'repar', 'anno',
        'email', 'esperienza_acquisita', 'risultati_ottenuti',
        'arricchimento_professionale', 'impegno', 'qualita_prestazione', 'totale', 'totale_pond', 'ha_diritto', 'motivo', 'excellences_count_last_3_years', ];

    public string $sendmail_where = 'totale > 0';

    protected $fillable = ['ente', 'matr', 'stabi', 'repar', 'anno',
        'cognome', 'nome',
        'categoria_eco', 'categoria_ecoval',
        'email', 'esperienza_acquisita', 'risultati_ottenuti',
        'arricchimento_professionale', 'impegno', 'qualita_prestazione', 'totale', 'totale_pond', 'vincitore',
        'gg_cateco_posfun',
        'gg_cateco_posfun_no_asz',
        'gg_in_sede',
        'gg_presenza_anno',
        'gg_assenza_anno',
        'gg_fuori_sede',
        'gg_posiz_1_in_sede',
        'gg_cateco_fuori_sede',
        'gg_cateco_in_sede',
        'gg_cateco_posfun_fuori_sede',
        'gg_cateco_posfun_in_sede',
        'gg_cateco_posfun_in_sede_no_asz',
        'gg_asz_cateco_posfun_fuori_sede',
        'gg_asz_cateco_posfun_in_sede',
        'gg_cateco_posfun_fuori_sede',
        'gg_cateco_fuori_sede',
        'gg_anno',
        'gg_asz_tip_cod_escluso_subito',
        'gg_aspettative_pond_fuori_sede',
        'gg_aspettative_pond_in_sede',
        'ptime', // aggiunto
        'costo_fascia_up', // da ced03f

        'peso_perf_ind_media',
        'perf_ind_media',
        'titolo_di_studio',
        'costo_fascia_up',
        'punt_progressione', // punteggio progressione da 1 a 4
        'punt_progressione_finale', // somma(moltiplicazione dei criteri * peso)
        'valutatore_id',
        'benificiario_progressione',
        'rep2kd', 'rep2ka', 'propro', 'posfun', 'posiz', 'disci1', 'qua2kd', 'qua2ka', 'dal', 'al',
        'excellences_count_last_3_years',
        'valore_differenziale_rapportato_pt',
        'gg_no_asz',

        'gg_integ_params',
        'gg_integ_params_asz',
        'gg_esperienza_no_asz', // gg_cateco_posf_no_asz se non c'e' gg_integ_params
        'ha_diritto',
        'motivo',
    ];

    /**
     * Validate the model data.
     *
     * @param array<string, mixed> $data
     */
    public function validate(array $data): Validator
    {
        $rules = [
            'cognome' => 'required|string|max:50',
            'nome' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'propro' => 'required|integer',
            'posfun' => 'required|integer',
            'categoria_eco' => 'required|string|max:10',
            'posiz' => 'required|integer',
            'posiz_txt' => 'required|string|max:100',
            'clafun' => 'required|integer',
            'stabi' => 'required|integer',
            'stabi_txt' => 'required|string|max:100',
            'repar' => 'required|integer',
            'repar_txt' => 'required|string|max:100',
            'stabival' => 'required|integer',
            'reparval' => 'required|integer',
            'indir' => 'required|string|max:255',
            'gg_in_sede' => 'required|integer',
            'n_gg_in_sede' => 'required|integer',
            'gg_fuori_sede' => 'required|integer',
            'n_gg_fuori_sede' => 'required|integer',
            'gg_aspettative_in_sede' => 'required|integer',
            'gg_aspettative_fuori_sede' => 'required|integer',
            'gg_posiz_1_in_sede' => 'required|integer',
            'gg_presenza_anno' => 'required|integer',
            'gg_assenza_anno' => 'required|integer',
            'gg_asz_tip_cod_escluso_subito' => 'required|integer',
            'gg_anno' => 'required|integer',
            'gg_cateco_posfun' => 'required|integer',
            'rep003' => 'required|integer',
            'disci1' => 'required|integer',
            'disci1_txt' => 'required|string|max:100',
            'rep2kd' => 'required|integer',
            'rep2ka' => 'required|integer',
            'qua2kd' => 'required|integer',
            'qua2ka' => 'required|integer',
            'dal' => 'required|date',
            'al' => 'required|date',
            'gg' => 'required|integer',
            'anno' => 'required|integer',
            'esperienza_acquisita' => 'required|string',
            'peso_esperienza_acquisita' => 'required|numeric',
            'risultati_ottenuti' => 'required|string',
            'peso_risultati_ottenuti' => 'required|numeric',
            'arricchimento_professionale' => 'required|string',
            'peso_arricchimento_professionale' => 'required|numeric',
            'impegno' => 'required|string',
            'peso_impegno' => 'required|numeric',
            'qualita_prestazione' => 'required|string',
            'peso_qualita_prestazione' => 'required|numeric',
            'totale' => 'required|numeric',
            'totale_pond' => 'required|numeric',
            'ha_diritto' => 'required|boolean',
            'motivo' => 'required|string',
            'gg_aspettative_pond_in_sede' => 'required|numeric',
            'gg_aspettative_pond_fuori_sede' => 'required|numeric',
            'categoria_ecoval' => 'required|string|max:10',
            'posfunval' => 'required|integer',
            'gg_cateco_in_sede' => 'required|integer',
            'gg_cateco_fuori_sede' => 'required|integer',
            'gg_cateco_posfun_in_sede' => 'required|integer',
            'gg_cateco_posfun_fuori_sede' => 'required|integer',
            'gg_cateco_no_posfun_in_sede' => 'required|integer',
            'gg_cateco_no_posfun_fuori_sede' => 'required|integer',
            'gg_no_cateco_in_sede' => 'required|integer',
            'gg_no_cateco_fuori_sede' => 'required|integer',
            'gg_no_cateco_posfun_in_sede' => 'required|integer',
            'gg_no_cateco_posfun_fuori_sede' => 'required|integer',
            'gg_asz_cateco_posfun_in_sede' => 'required|integer',
            'gg_asz_cateco_posfun_fuori_sede' => 'required|integer',
            'gg_tot_pond' => 'required|numeric',
            'asz2ka' => 'required|integer',
            'gg_presenze_in_anno' => 'required|integer',
            'gg_assenze_in_anno' => 'required|integer',
            'ore_assenze_in_anno' => 'required|integer',
            'benificiario_progressione' => 'required|boolean',
            'vincitore' => 'required|boolean',
            'perf_ind_2015' => 'required|string',
            'perf_ind_2016' => 'required|string',
            'perf_ind_2017' => 'required|string',
            'perf_ind_2018' => 'required|string',
            'perf_ind_2014' => 'required|string',
            'perf_ind_media' => 'required|numeric',
            'peso_perf_ind_media' => 'required|string',
            'risultato' => 'required|string',
            'ptime' => 'required|numeric',
            'costo_fascia_up' => 'required|numeric',
            'valutatore_id' => 'required|integer',
            'titolo_di_studio' => 'required|string|max:100',
            'lang' => 'required|string|max:10',
            'punt_progressione' => 'required|integer',
            'punt_progressione_finale' => 'required|numeric',
            'gg_cateco_posfun_no_asz' => 'required|integer',
            'gg_cateco_posfun_in_sede_no_asz' => 'required|integer',
            'gg_ruolo' => 'required|integer',
            'perf_ind_2019' => 'required|string',
            'gg_asz' => 'required|integer',
            'hh_asz' => 'required|integer',
            'gg_cateco_sup_in_sede' => 'required|integer',
            'perf_ind_2020' => 'required|string',
            'eta' => 'required|numeric',
            'gg_in_sede_no_asz' => 'required|numeric',
            'valore_differenziale_rapportato_pt' => 'required|numeric',
            'perf_ind_2021' => 'required|string',
        ];

        return \Illuminate\Support\Facades\Validator::make($data, $rules);
    }

    /**
     * Get stabi_dirigente_parz data.
     *
     * @param array<string, mixed> $params
     * @return Collection<int, self>
     */
    /**
     * @param array{stabi?: int|string|null, repar?: int|string|null, anno?: int|string|null} $params
     * @return Collection<int, self>
     */
    public function stabi_dirigente_parz(array $params): Collection
    {
        $stabi = $params['stabi'] ?? null;
        $repar = $params['repar'] ?? null;
        $anno = $params['anno'] ?? null;

        if ($stabi === null || $repar === null || $anno === null) {
            throw new InvalidArgumentException('Missing required parameters: stabi, repar, anno');
        }

        return self::where('stabi', $stabi)
            ->where('repar', $repar)
            ->where('anno', $anno)
            ->orderBy('stabi_txt')
            ->orderBy('repar_txt')
            ->get();
    }

    /**
     * Get stabi options.
     *
     * @return array<int|string, string>
     */
    public function stabi_opts(): array
    {
        $opts = Repart::where('repar', 0)
            ->where('stabi', '>', 500)
            ->get();

        $result = [];
        $result[''] = '---SELEZIONA---';

        foreach ($opts as $opt) {
            $result[$opt->stabi] = $opt->stabi.'] '.$opt->dest1;
        }

        return $result;
    }

    // end function stabi_opts

    /**
     * Filter records based on parameters.
     *
     * @param  array  $params
     */
    /**
     * @param array<string, mixed> $params
     * @return Builder<self>
     */
    public static function filter(array $params): Builder
    {
        $query = self::query();

        if (isset($params['anno'])) {
            $query->where('anno', $params['anno']);
        }

        // Add more filtering conditions as needed
        // Example:
        // if (isset($params['field'])) {
        //     $query->where('field', $params['field']);
        // }

        return $query;
    }

    /*  --- spostato nel trait --
    asz00k1 solo ente, matr
    asz00k1RangeDate ente, matr, dal, al
    asz00k1RageDate etc etc
    public function asz00k1(): void {
        $anno=$this->anno;
        $tmp=[];
        foreach ($this->codiciAspettative()->get() as $row) {
            $tmp[]=$row->tipo.'-'.$row->codice;
        }
        $lista_codici_aspettative=implode(',', $tmp);
        $asz=Asz00k1::where('ente', $this->ente)
                    ->where('matr', $this->matr)
                    ->whereRaw('find_in_set(concat(asztip,"-",aszcod),"'.$lista_codici_aspettative.'")');

        return $asz;
    }
    //*/

    /**
     * Calcola il coefficiente peso da propro/posfun tramite tabella coeff.
     *
     * Non usare il nome `peso()`: riservato alla relazione HasOne verso `Pesi` (SchedaTrait, CompilaScheda).
     *
     * @param array<string, mixed> $params
     */
    public function resolveCoeffPesoFromParams(array $params): int
    {
        extract($params);

        if (! isset($propro)) {
            throw new Exception('[propro] is not set');
        }

        if (! isset($posfun)) {
            throw new Exception('[posfun] is not set');
        }

        $sk = 'gg_';
        if ($this->propro === $propro) {
            $sk .= 'propro';
        } else {
            $sk .= 'no_propro';
        }

        $sk .= '_';
        if ($this->posfun === $posfun) {
            $sk .= 'posfun';
        } else {
            $sk .= 'no_posfun';
        }

        $sk .= '_in_sede';
        $coeff = $this->coeff()->where('name', $sk)->first();

        if (! $coeff instanceof Coeff) {
            throw new Exception('coeff name not set');
        }

        return (int) $coeff->value;
    }

    // ---------------------------------------------------------------------------------------------------------------------------
    // ---------------- UPDATES ---------------------
    // ----------------------------------------------

    /**
     * @param array{anno?: int|string} $params
     */
    public static function updateVincitori(array $params): void
    {
        extract($params);

        if (! isset($anno)) {
            throw new Exception('[anno] is not set');
        }

        $maxcatecoposfun = MaxCatecoPosfunAnno::where('anno', $anno)->orderBy('cateco')->orderBy('posfun')->get();
        echo '<h3> Vincitori : '.(string) $maxcatecoposfun->sum('aventi_diritto_eff').'</h3>';
        foreach ($maxcatecoposfun as $item) {
            $schede_obj = $item->schede();
            $limit = $item->aventi_diritto_eff;
            $schede_obj->update(['vincitore' => 0]);
            $vincitori = $schede_obj->select('id', 'matr', 'cognome', 'nome', 'categoria_ecoval', 'posfunval', 'vincitore')->distinct()
                ->where('ha_diritto', 1)->orderBy('totale', 'desc')->groupBy('matr')
                ->where('totale', '>', 0)->limit($limit);
            $res = $vincitori->update(['vincitore' => 1]);
            /*-- 4 debug --
            echo '<hr/><pre>';print_r($item->toArray());echo '</pre>';
            echo '<pre>'.$vincitori->toSql().'</pre>';
            echo '<pre>';print_r($vincitori->get()->toArray());echo '</pre>';
            echo '<pre>'.print_r($res).'</pre>';
            */
            foreach ($vincitori->get()->where('vincitore', 0) as $loser) {
                if ($loser instanceof self) {
                    self::where('id', $loser->id)->update(['vincitore' => 1]);
                }
            }
        }
    }

    /**
     * { item_description }.
     */
    /**
     * @param array{anno: int|string} $params
     */
    public static function updatePeso(array $params): void
    {
        extract($params);
        /*
         $valutaz_fields=['esperienza_acquisita'
        ,'risultati_ottenuti'
            ,'arricchimento_professionale','impegno','qualita_prestazione'];
        */
        $scheda_obj = new self;
        $peso_obj = new Pesi;
        $valutaz_fields = $scheda_obj->valutaz_fields;
        // $valutaz_fields=self::$valutaz_fields;
        reset($valutaz_fields);
        foreach ($valutaz_fields as $valutaz_field) {
            $sql = 'update '.$scheda_obj->getTable().' as A set A.peso_'.(string) $valutaz_field.' = (
				select B.peso_'.(string) $valutaz_field.' from '.$peso_obj->getTable().' as B
				where A.anno=B.anno and find_in_set(A.propro,B.lista_propro) limit 1
			) where A.anno='.(string) $params['anno'];
            // echo '<pre>'.$sql.'</pre>';
            $scheda_obj->getConnection()->statement($sql);
        }
    }

    /**
     * @param array{where?: string, force?: int} $params
     */
    public static function updateTotale(array $params): void
    {
        // totale aggiornato dall'edit per questioni di approssimazioni
        $self = new self;
        $valutaz_fields = $self->valutaz_fields;
        reset($valutaz_fields);
        $sql_arr = [];
        foreach ($valutaz_fields as $valutaz_field) {
            $sql_arr[] = (string) $valutaz_field.' * peso_'.(string) $valutaz_field;
        }
        // il force si togliera'
        if (isset($params['where'], $params['force']) && $params['force'] === 1) {
            $where = $params['where'];
            $where = str_replace('schede.', 'A.', (string) $where);
            $tbl = (string) $self->getTable();
            $sql = 'update '.$tbl.' as A set A.totale=('.\chr(13).'(';
            $sql .= implode(' ) +'.\chr(13).' ( ', $sql_arr);
            $sql .= ')'.\chr(13).')/100
				where ';
            if (\is_string($where)) {
                $sql .= $where;
            } else {
                dddx($where);
            }

            echo '['.__LINE__.']['.__FILE__.']['.__FUNCTION__.']<pre>'.$sql.'</pre>';
            $self->getConnection()->statement($sql);
        }
    }

    /**
     * @param array{anno: int|string} $params
     */
    public static function updateEsperienzaAcquisita(array $params): void
    {
        $self = new self;
        // $sql='delete from cateco_posfun_max_tot_pond where anno='.$params['anno'];
        // $scheda_obj->getConnection()->statement($sql);
        // MaxCatecoPosfunAnno -> table =cateco_posfun_max_tot_pond
        $rows = self::select('categoria_ecoval', 'posfunval', 'anno')
            ->where('anno', $params['anno'])
            ->where('ha_diritto', 1)
            ->orderBy('categoria_ecoval')
            ->orderBy('posfunval')
            ->orderBy('anno')
            ->distinct();
        foreach ($rows->get() as $row) {
            MaxCatecoPosfunAnno::firstOrCreate([
                'cateco' => $row->categoria_ecoval,
                'posfun' => $row->posfunval,
                'anno' => $row->anno,
            ]);
        }

        /*
        $sql='insert cateco_posfun_max_tot_pond(cateco,posfun,anno)
            (select distinct A.categoria_ecoval,substr(A.posfun,-1),anno
                from '.$scheda_obj->getTable().' as A  where A.anno='.$params['anno'].'
                and A.ha_diritto=1
                order by A.categoria_ecoval,substr(A.posfun,-1)
            )';
        $scheda_obj->getConnection()->statement($sql);
        */
        $sql = ' update cateco_posfun_max_tot_pond As A set max_gg_tot_pond=(
			select max(gg_tot_pond) from  '.$self->getTable().' as B
			where A.anno=B.anno
			and A.cateco=B.categoria_ecoval
			and substr(A.posfun,-1)=substr(B.posfun,-1)
			and B.ha_diritto=1
			) where A.anno='.(string) $params['anno'];
        $self->getConnection()->statement($sql);

        $sql = 'update '.$self->getTable().' as A set A.esperienza_acquisita=(select A.gg_tot_pond*10/B.max_gg_tot_pond from cateco_posfun_max_tot_pond as B
			where A.anno=B.anno
			and A.categoria_ecoval=B.cateco
			and substr(A.posfun,-1)=substr(B.posfun,-1)
			) where A.anno='.(string) $params['anno'].' and A.ha_diritto=1';
        $self->getConnection()->statement($sql);
    }

    // --------------------------------------------------------------------------------------
    // --------- functions ---------
    /**
     * Update fields based on parameters.
     *
     * @param  array  $params
     *
     * @throws RuntimeException When required parameters are missing
     */
    /**
     * @param array<string, mixed> $params
     */
    public static function updateFields(array $params = []): void
    {
        $route_parameters = [];
        if (Route::current() !== null && method_exists(Route::current(), 'parameters')) {
            $route_parameters = getRouteParameters();
        }

        // Merge route parameters with provided parameters
        $params = array_merge($route_parameters, $params);

        // Check required parameters
        if (! isset($params['anno'])) {
            throw new RuntimeException('[anno] is not set');
        }

        if (! isset($params['stabi'])) {
            throw new RuntimeException('[stabi] is not set');
        }

        if (! isset($params['repar'])) {
            throw new RuntimeException('[repar] is not set');
        }

        $anno = (int) $params['anno'];
        $stabi = $params['stabi'];
        $repar = $params['repar'];

        $rows0 = Rep00f::where('repst1', $stabi)
            ->where('repre1', $repar)
            ->ofYear($anno)
            ->whereRaw('repann=""');
        foreach ($rows0->get() as $row) {
            $parz = ['ente' => $row->ente,
                'matr' => $row->matr,
                'stabi' => $row->repst1,
                'repar' => $row->repre1,
                'rep2kd' => $row->rep2kd,
                'rep2ka' => $row->rep2ka,
                'anno' => $anno, ];

            $obj = self::firstOrCreate($parz);
            $obj->rep2kd = $row->rep2kd;
            $obj->rep2ka = $row->rep2ka;
            if ($obj->dal === null) {
                // $obj->dal = Carbon::createFromDate($anno, 1, 1);  // Property Modules\Progressioni\Models\Scheda::$dal (int|null) does not accept Carbon\Carbon.
                $obj->dal = (int) ((int) $anno * 10000 + 101);
            }

            if ($obj->al === null) {
                // $obj->al = Carbon::createFromDate($anno, 12, 31); // Property Modules\Progressioni\Models\Scheda::$al (int|null) does not accept Carbon\Carbon.
                $obj->al = (int) ((int) $anno * 10000 + 1231);
            }

            if ($obj->propro === 0 || $obj->propro === null) {
                $dal = $obj->dal;
                $al = $obj->al;
                $qua00f = $obj->anag?->qua00f()
                    ->select('propro', 'posfun', 'posiz')
                    ->distinct()
                    ->where(function (Builder $query) use ($dal, $al): void {
                        $query->whereRaw(
                            '(? between qua2kd and qua2ka) or (? >= qua2kd and qua2ka = 0) or (? between qua2kd and qua2ka) or (? >= qua2kd and qua2ka = 0) or (qua2kd between ? and ?) or (qua2ka between ? and ?)',
                            [$dal, $dal, $al, $al, $dal, $al, $dal, $al]
                        );
                    });
                // echo '<br/>'.$qua00f->count().' - '.$qua00f->first()->propro.'  - '.$qua00f->first()->posfun;
                if ($qua00f && $qua00f->get()->count() === 1) {
                    $firstRecord = $qua00f->first();
                    if ($firstRecord !== null) {
                        $obj->propro = $firstRecord->propro;
                        $obj->posfun = $firstRecord->posfun;
                        $obj->posiz = $firstRecord->posiz;
                    }
                } else {
                    echo '<br/>$qua00f->count() : '.($qua00f ? $qua00f->count() : 0);
                    echo '<br/>ente :'.$obj->ente;
                    echo '<br/>matr :'.$obj->matr;
                    echo "<br/>qualcosa e' andato storto [".__LINE__.']['.__FILE__.']';
                    echo '<pre>';
                    print_r($qua00f ? $qua00f->toSql() : 'N/A');
                    $anag = $obj->anag;
                    $qua00f = $anag ? $anag->qua00f()
                        ->where(function (Builder $query) use ($dal, $al): void {
                            $query->whereRaw(
                                '(? between qua2kd and qua2ka) or (? >= qua2kd and qua2ka = 0) or (? between qua2kd and qua2ka) or (? >= qua2kd and qua2ka = 0) or (qua2kd between ? and ?) or (qua2ka between ? and ?)',
                                [$dal, $dal, $al, $al, $dal, $al, $dal, $al]
                            );
                        })
                        ->orderBy('qua2kd')
                        ->get() : collect();

                    // foreach($qua00f as $v_qua00f){
                    $al_old = $obj->al;
                    // $obj->al = Carbon::parse($qua00f[0]->qua2kd);//875    Property Modules\Progressioni\Models\Scheda::$al (int|null) does not accept Carbon\Carbon.
                    // $obj->al = (int) Carbon::parse($qua00f[0]->qua2kd)->format('Ymd');
                    /** @var object{qua2kd: mixed} $firstItem */
                    $firstItem = $qua00f[0];
                    $obj->al = (int) $firstItem->qua2kd;
                    $obj->save();

                    $obj1 = $obj->replicate();
                    // $obj1->dal = Carbon::parse($qua00f[1]->qua2kd);//Property Modules\Progressioni\Models\Scheda::$dal (int|null) does not accept Carbon\Carbon.
                    /** @var object{qua2kd: mixed, qua2ka: mixed} $secondItem */
                    $secondItem = $qua00f[1];
                    $obj1->dal = (int) $secondItem->qua2kd;
                    $obj1->al = $secondItem->qua2ka !== 0 ? (int) $secondItem->qua2ka : $al_old;
                    // $obj1->id = null;  889    Property Modules\Progressioni\Models\Scheda::$id (int) does not accept null.
                    $obj1->save();
                }
            }

            $obj->save();
            // echo '<br/><pre>['.$obj->id.']</pre>';
        }

        $obj = new self;
        $table = $obj->getTable();
        $conn = $obj->getConnection();
        $where = $table.'.anno="'.(string) $anno.'" ';

        // Anag::massUpdateCognomeNome(['conn' => $conn, 'table' => $table, 'where' => $where]);
        app(MassUpdateCognomeNomeAction::class)->execute($conn, $table, $where);
        // Anag::massUpdateCategoriaEco(['conn' => $conn, 'table' => $table, 'where' => $where]);
        app(MassUpdateCategoriaEcoAction::class)->execute($conn, $table, $where);
        // Anag::massUpdatePosizTxt(['conn' => $conn, 'table' => $table, 'where' => $where]);
        app(MassUpdatePosizTxtAction::class)->execute($conn, $table, $where);
        // Anag::massUpdateStabiTxtReparTxt(['conn' => $conn, 'table' => $table, 'where' => $where]);
        app(MassUpdateStabiTxtReparTxtAction::class)->execute($conn, $table, $where);
    }

    /**
     * Generate PDF content for the view.
     *
     * @param  string  $view  The view name to render
     * @return string The generated PDF content
     */
    public function content_PDF(string $view): string
    {
        $params = [];
        if (Route::current() !== null) {
            $params = getRouteParameters();
        }

        $view_params = [
            'view' => $view,
            'row' => $this,
            'anno' => $this->anno,
            'params' => $params,
        ];

        /** @phpstan-ignore-next-line */
        $html = view($view, $view_params);
        $content = $html->render();

        // Get the PDF content
        $pdfResult = HtmlService::toPdf($content);

        // HtmlService::toPdf returns string
        return $pdfResult;
    }

    // end content_PDF

    // ------------------------------------------------------------------------------------
    /**
     * @param array<string, mixed> $params
     */
    public function ggInSedeTotByArray(array $params): ?int
    {
        $criteri = $this->criteriEsclusione;
        if (! $criteri) {
            return null;
        }

        $data_presenza_dal = $criteri->firstWhere('name', 'data_presenza_dal');
        $date_min = $data_presenza_dal ? $data_presenza_dal->value : null;
        if (\is_object($date_min)) {
            $date_min = $date_min->format('Ymd');
        }

        $data_presenza_al = $criteri->firstWhere('name', 'data_presenza_al');
        $date_max = $data_presenza_al && \is_object($data_presenza_al->value) ? $data_presenza_al->value->format('Ymd') : null;
        $al = $date_max;
        extract($params);

        $anno = $this->anno;
        $tbl = app(CategoriaPropro::class)->getTable();

        /** @var Builder<\Modules\Progressioni\Models\Scheda> $qua00f */
        $qua00f = $this->qua00f()->join('progressione.'.$tbl, static function (JoinClause $join) use ($anno, $tbl): void {
            $join->where($tbl.'.anno', $anno);
            $join->whereRaw('find_in_set(propro,lista_propro)');
            $join->limit(1);
        });
        if (isset($posfun)) {
            // if (isset($posfun) && substr($posfun, -1)!=substr($this->attributes['posfun'], -1) ) {
            $qua00f->whereRaw('SUBSTR(posfun,-1)=?', [(string) $posfun]);
        }

        if (isset($date_max)) {
            $qua00f->where('qua2kd', '<=', $date_max);
        }

        if (isset($date_min)) {
            $qua00f->where('qua2kd', '>=', $date_min);
        }

        $tot = 0;

        foreach ($qua00f->get() as $row) {
            /** @var Qua00f $row */
            $qua2kd = $row->getAttribute('qua2kd') ?? 0;
            $qua2ka = $row->getAttribute('qua2ka') ?? 0;

            $dal = $qua2kd;
            if (isset($date_min)) {
                $dal = ($qua2kd >= $date_min) ? $qua2kd : $date_min;
            }

            if (isset($date_max)) {
                $al = ($qua2ka >= $date_max || $qua2ka === 0) ? $date_max : $qua2ka;
            }

            $gg = 0;
            if ($dal <= $al) {
                $parsedDal = is_numeric($dal) ? Carbon::parse($dal) : Carbon::now();
                $parsedAl = is_numeric($al) ? Carbon::parse($al) : Carbon::now();
                $gg = (int) ($parsedDal->diffInDays($parsedAl, true) + 1);
            }

            $tot += $gg;
            // echo '<br/>['.$row->qua2kd.' '.$row->qua2ka.']  ['.$dal.' - '.$al.'] ['.$gg.']';
        }

        return (int) $tot;
    }

    public function getGgRuoloAttribute(): ?int
    {
        // Default implementation - this should be computed based on actual business logic
        return 0;
    }

    /**
     * Imposta il flag diritto alla progressione.
     */
    public function setHaDirittoAttribute(?int $value): void
    {
        $this->attributes['ha_diritto'] = $value;
    }

    /**
     * Imposta il motivo di esclusione.
     */
    public function setMotivoAttribute(?string $value): void
    {
        $this->attributes['motivo'] = $value;
    }

    /**
     * Calculate total days in office with proper return type.
     *
     * @param  mixed  $data
     */
    public function ggInSedeTot($data): ?int
    {
        if ($data instanceof GgFilterData) {
            $result = $this->anag?->ggInSedeTot($data);
        } else {
            $filterData = GgFilterData::from($data);
            $result = $this->anag?->ggInSedeTot($filterData);
        }

        return is_numeric($result) ? (int) $result : null;
    }
}
