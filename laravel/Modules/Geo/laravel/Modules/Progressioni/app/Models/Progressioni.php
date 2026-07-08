<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Modules\Activity\Models\Activity;
use Modules\Performance\Models\Individuale;
use Modules\Progressioni\Database\Factories\ProgressioniFactory;
use Modules\Progressioni\Models\Traits\ConvertedTrait;
use Modules\Progressioni\Models\Traits\ProgressioniTrait;
use Modules\Ptv\Models\BaseScheda;
use Modules\Ptv\Models\Profile;
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

/**
 * Modules\Progressioni\Models\Progressioni.
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
 * @property int|null $posiz1
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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
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
 * @property string|null $perf_ind_2019
 * @property int|null $gg_asz
 * @property int|null $hh_asz
 * @property int|null $gg_cateco_posfun_in_sede_no_asz
 * @property int|null $gg_cateco_sup_in_sede
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
 * @method static ProgressioniFactory factory($count = null, $state = [])
 * @method static Builder|Progressioni newModelQuery()
 * @method static Builder|Progressioni newQuery()
 * @method static Builder|Progressioni ofDate(int $date)
 * @method static Builder|Progressioni ofEnteYear(int $ente, int $year)
 * @method static Builder|Progressioni ofQuarter(int $quarter, int $year)
 * @method static Builder|Progressioni ofRangeDate(int $date_start, int $date_end)
 * @method static Builder|Progressioni ofYear(int $year)
 * @method static Builder|Progressioni query()
 * @method static Builder|Progressioni whereAl($value)
 * @method static Builder|Progressioni whereAnno($value)
 * @method static Builder|Progressioni whereArricchimentoProfessionale($value)
 * @method static Builder|Progressioni whereAsz2ka($value)
 * @method static Builder|Progressioni whereBenificiarioProgressione($value)
 * @method static Builder|Progressioni whereCategoriaEco($value)
 * @method static Builder|Progressioni whereCategoriaEcoval($value)
 * @method static Builder|Progressioni whereClafun($value)
 * @method static Builder|Progressioni whereCognome($value)
 * @method static Builder|Progressioni whereCostoFasciaUp($value)
 * @method static Builder|Progressioni whereCreatedAt($value)
 * @method static Builder|Progressioni whereCreatedBy($value)
 * @method static Builder|Progressioni whereCreatedIp($value)
 * @method static Builder|Progressioni whereDal($value)
 * @method static Builder|Progressioni whereDeletedAt($value)
 * @method static Builder|Progressioni whereDeletedBy($value)
 * @method static Builder|Progressioni whereDeletedIp($value)
 * @method static Builder|Progressioni whereDisci1($value)
 * @method static Builder|Progressioni whereDisci1Txt($value)
 * @method static Builder|Progressioni whereEmail($value)
 * @method static Builder|Progressioni whereEnte($value)
 * @method static Builder|Progressioni whereEsperienzaAcquisita($value)
 * @method static Builder|Progressioni whereEta($value)
 * @method static Builder|Progressioni whereExcellencesCountLast3Years($value)
 * @method static Builder|Progressioni whereGg($value)
 * @method static Builder|Progressioni whereGgAnno($value)
 * @method static Builder|Progressioni whereGgAspettativeFuoriSede($value)
 * @method static Builder|Progressioni whereGgAspettativeInSede($value)
 * @method static Builder|Progressioni whereGgAspettativePondFuoriSede($value)
 * @method static Builder|Progressioni whereGgAspettativePondInSede($value)
 * @method static Builder|Progressioni whereGgAssenzaAnno($value)
 * @method static Builder|Progressioni whereGgAssenzeInAnno($value)
 * @method static Builder|Progressioni whereGgAsz($value)
 * @method static Builder|Progressioni whereGgAszCatecoPosfunFuoriSede($value)
 * @method static Builder|Progressioni whereGgAszCatecoPosfunInSede($value)
 * @method static Builder|Progressioni whereGgAszTipCodEsclusoSubito($value)
 * @method static Builder|Progressioni whereGgCatecoFuoriSede($value)
 * @method static Builder|Progressioni whereGgCatecoInSede($value)
 * @method static Builder|Progressioni whereGgCatecoNoPosfunFuoriSede($value)
 * @method static Builder|Progressioni whereGgCatecoNoPosfunInSede($value)
 * @method static Builder|Progressioni whereGgCatecoPosfun($value)
 * @method static Builder|Progressioni whereGgCatecoPosfunFuoriSede($value)
 * @method static Builder|Progressioni whereGgCatecoPosfunInSede($value)
 * @method static Builder|Progressioni whereGgCatecoPosfunInSedeNoAsz($value)
 * @method static Builder|Progressioni whereGgCatecoPosfunNoAsz($value)
 * @method static Builder|Progressioni whereGgCatecoSupInSede($value)
 * @method static Builder|Progressioni whereGgFuoriSede($value)
 * @method static Builder|Progressioni whereGgInSede($value)
 * @method static Builder|Progressioni whereGgInSedeNoAsz($value)
 * @method static Builder|Progressioni whereGgNoCatecoFuoriSede($value)
 * @method static Builder|Progressioni whereGgNoCatecoInSede($value)
 * @method static Builder|Progressioni whereGgNoCatecoPosfunFuoriSede($value)
 * @method static Builder|Progressioni whereGgNoCatecoPosfunInSede($value)
 * @method static Builder|Progressioni whereGgPosiz1InSede($value)
 * @method static Builder|Progressioni whereGgPresenzaAnno($value)
 * @method static Builder|Progressioni whereGgPresenzeInAnno($value)
 * @method static Builder|Progressioni whereGgTotPond($value)
 * @method static Builder|Progressioni whereHaDiritto($value)
 * @method static Builder|Progressioni whereHhAsz($value)
 * @method static Builder|Progressioni whereId($value)
 * @method static Builder|Progressioni whereImpegno($value)
 * @method static Builder|Progressioni whereIndir($value)
 * @method static Builder|Progressioni whereLang($value)
 * @method static Builder|Progressioni whereMatr($value)
 * @method static Builder|Progressioni whereMotivo($value)
 * @method static Builder|Progressioni whereNGgFuoriSede($value)
 * @method static Builder|Progressioni whereNGgInSede($value)
 * @method static Builder|Progressioni whereNome($value)
 * @method static Builder|Progressioni whereOreAssenzeInAnno($value)
 * @method static Builder|Progressioni wherePerfInd2014($value)
 * @method static Builder|Progressioni wherePerfInd2015($value)
 * @method static Builder|Progressioni wherePerfInd2016($value)
 * @method static Builder|Progressioni wherePerfInd2017($value)
 * @method static Builder|Progressioni wherePerfInd2018($value)
 * @method static Builder|Progressioni wherePerfInd2019($value)
 * @method static Builder|Progressioni wherePerfInd2020($value)
 * @method static Builder|Progressioni wherePerfInd2021($value)
 * @method static Builder|Progressioni wherePerfIndCountLast3Years($value)
 * @method static Builder|Progressioni wherePerfIndMedia($value)
 * @method static Builder|Progressioni wherePesoArricchimentoProfessionale($value)
 * @method static Builder|Progressioni wherePesoEsperienzaAcquisita($value)
 * @method static Builder|Progressioni wherePesoImpegno($value)
 * @method static Builder|Progressioni wherePesoPerfIndMedia($value)
 * @method static Builder|Progressioni wherePesoQualitaPrestazione($value)
 * @method static Builder|Progressioni wherePesoRisultatiOttenuti($value)
 * @method static Builder|Progressioni wherePosfun($value)
 * @method static Builder|Progressioni wherePosfunval($value)
 * @method static Builder|Progressioni wherePosiz($value)
 * @method static Builder|Progressioni wherePosizTxt($value)
 * @method static Builder|Progressioni wherePostType($value)
 * @method static Builder|Progressioni wherePropro($value)
 * @method static Builder|Progressioni wherePtime($value)
 * @method static Builder|Progressioni wherePuntProgressione($value)
 * @method static Builder|Progressioni wherePuntProgressioneFinale($value)
 * @method static Builder|Progressioni whereQua2ka($value)
 * @method static Builder|Progressioni whereQua2kd($value)
 * @method static Builder|Progressioni whereQualitaPrestazione($value)
 * @method static Builder|Progressioni whereRep003($value)
 * @method static Builder|Progressioni whereRep2ka($value)
 * @method static Builder|Progressioni whereRep2kd($value)
 * @method static Builder|Progressioni whereRepar($value)
 * @method static Builder|Progressioni whereReparTxt($value)
 * @method static Builder|Progressioni whereReparval($value)
 * @method static Builder|Progressioni whereRisultatiOttenuti($value)
 * @method static Builder|Progressioni whereRisultato($value)
 * @method static Builder|Progressioni whereSchedaType($value)
 * @method static Builder|Progressioni whereStabi($value)
 * @method static Builder|Progressioni whereStabiTxt($value)
 * @method static Builder|Progressioni whereStabival($value)
 * @method static Builder|Progressioni whereTitoloDiStudio($value)
 * @method static Builder|Progressioni whereTotale($value)
 * @method static Builder|Progressioni whereTotalePond($value)
 * @method static Builder|Progressioni whereUpdatedAt($value)
 * @method static Builder|Progressioni whereUpdatedBy($value)
 * @method static Builder|Progressioni whereUpdatedIp($value)
 * @method static Builder|Progressioni whereValoreDifferenzialeRapportatoPt($value)
 * @method static Builder|Progressioni whereValutatoreId($value)
 * @method static Builder|Progressioni whereVincitore($value)
 * @method static Builder|Progressioni withDays(int $date_min, int $date_max)
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
 * @property Carbon|null $refreshed_at
 * @property int|null $gg_integ_params
 * @property int|null $gg_esperienza_no_asz
 * @property float|null $gg_integ_params_asz
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Progressioni ofEnte(int $ente)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Progressioni ofFourMonthPeriod(int $fourMonthPeriod, int $year)
 * @method static Builder<static>|Progressioni whereGgAszCateco($value)
 * @method static Builder<static>|Progressioni whereGgAszCatecoFuoriSede($value)
 * @method static Builder<static>|Progressioni whereGgAszCatecoInSede($value)
 * @method static Builder<static>|Progressioni whereGgAszInSede($value)
 * @method static Builder<static>|Progressioni whereGgCateco($value)
 * @method static Builder<static>|Progressioni whereGgCatecoNoAsz($value)
 * @method static Builder<static>|Progressioni whereGgCatecoNoPosfunNoAsz($value)
 * @method static Builder<static>|Progressioni whereGgEsperienzaNoAsz($value)
 * @method static Builder<static>|Progressioni whereGgFuoriSedeNoAsz($value)
 * @method static Builder<static>|Progressioni whereGgIntegParams($value)
 * @method static Builder<static>|Progressioni whereGgIntegParamsAsz($value)
 * @method static Builder<static>|Progressioni whereGgNoAsz($value)
 * @method static Builder<static>|Progressioni whereHhAszInSede($value)
 * @method static Builder<static>|Progressioni wherePerfInd1($value)
 * @method static Builder<static>|Progressioni wherePerfInd2($value)
 * @method static Builder<static>|Progressioni wherePerfInd2022($value)
 * @method static Builder<static>|Progressioni wherePerfInd2023($value)
 * @method static Builder<static>|Progressioni wherePerfInd2024($value)
 * @method static Builder<static>|Progressioni wherePerfInd2025($value)
 * @method static Builder<static>|Progressioni wherePerfInd2026($value)
 * @method static Builder<static>|Progressioni wherePerfInd2027($value)
 * @method static Builder<static>|Progressioni wherePerfInd2028($value)
 * @method static Builder<static>|Progressioni wherePerfInd2029($value)
 * @method static Builder<static>|Progressioni wherePerfInd2030($value)
 * @method static Builder<static>|Progressioni wherePerfInd3($value)
 * @method static Builder<static>|Progressioni whereRefreshedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Progressioni withCalculatedData()
 *
 * @mixin \Eloquent
 */
class Progressioni extends BaseScheda
{
    use ConvertedTrait;
    use ProgressioniTrait;

    // use EnteMatrRelationship;
    // use EnteMatrYearRelationship;
    protected $connection = 'progressione';

    protected $fillable = [
        'ente', 'matr', 'cognome', 'nome', 'propro', 'posfun',
        'posiz',
        'categoria_eco', 'categoria_ecoval', 'posfunval',
        'stabi', 'repar', 'anno',
        'email', 'esperienza_acquisita', 'risultati_ottenuti',
        'arricchimento_professionale', 'impegno', 'qualita_prestazione', 'totale', 'totale_pond',
        'ha_diritto', 'motivo',
        'rep2kd', 'rep2ka',
        'qua2kd', 'qua2ka',
        'disci1',
        'dal', 'al',
        'valutatore_id',

        'punt_progressione', // punteggio progressione da 1 a 4
        'punt_progressione_finale', // somma(moltiplicazione dei criteri * peso)
        'benificiario_progressione',
        'rep2kd', 'rep2ka', 'propro', 'posfun', 'posiz', 'disci1', 'qua2kd', 'qua2ka', 'dal', 'al',
        'excellences_count_last_3_years',
        // -----------------------------------
        'posiz_txt', 'clafun', 'stabi_txt', 'repar_txt', 'stabival', 'reparval', 'indir', 'gg_in_sede', 'n_gg_in_sede', 'gg_fuori_sede', 'n_gg_fuori_sede',
        'gg_aspettative_in_sede', 'gg_aspettative_fuori_sede', 'gg_posiz_1_in_sede', 'gg_presenza_anno',
        'gg_assenza_anno', 'gg_asz_tip_cod_escluso_subito', 'gg_anno', 'gg_cateco_posfun', 'rep003', 'disci1_txt',
        'gg', 'peso_esperienza_acquisita', 'peso_risultati_ottenuti', 'peso_arricchimento_professionale',
        'peso_impegno', 'peso_qualita_prestazione', 'gg_aspettative_pond_in_sede', 'gg_aspettative_pond_fuori_sede',
        'gg_cateco_in_sede', 'gg_cateco_fuori_sede', 'gg_cateco_posfun_in_sede', 'gg_cateco_posfun_fuori_sede',
        'gg_cateco_no_posfun_in_sede', 'gg_cateco_no_posfun_fuori_sede', 'gg_no_cateco_in_sede', 'gg_no_cateco_fuori_sede',
        'gg_no_cateco_posfun_in_sede', 'gg_no_cateco_posfun_fuori_sede', 'gg_asz_cateco_posfun_in_sede',
        'gg_asz_cateco_posfun_fuori_sede', 'gg_tot_pond', 'asz2ka', 'gg_presenze_in_anno', 'gg_assenze_in_anno',
        'ore_assenze_in_anno', 'vincitore',  'risultato', 'ptime', 'costo_fascia_up', 'titolo_di_studio',
        'gg_cateco_posfun_no_asz', 'gg_cateco_posfun_in_sede_no_asz',
        'gg_cateco_sup_in_sede', 'gg_asz', 'hh_asz', 'eta', 'gg_in_sede_no_asz', 'scheda_type',
        'post_type',
        'ente', 'matr', 'stabi', 'repar', 'rep2kd', 'rep2ka', 'anno', 'propro', 'posfun', 'posiz', 'disci1', 'qua2kd', 'qua2ka', 'dal', 'al',
        'gg_no_asz', 'hh_asz_in_sede',
        'refreshed_at',
        'peso_perf_ind_media',
        'perf_ind_media',
        'perf_ind_2014', 'perf_ind_2015', 'perf_ind_2016', 'perf_ind_2017', 'perf_ind_2018', 'perf_ind_2019', 'perf_ind_2020', 'perf_ind_2021',
        'perf_ind_2022', 'perf_ind_2023', 'perf_ind_2024', 'perf_ind_2025', 'perf_ind_2026', 'perf_ind_2027', 'perf_ind_2028', 'perf_ind_2029',
        'perf_ind_2030',
        // -----------------
        'gg_integ_params',
        'gg_integ_params_asz',
        'gg_esperienza_no_asz', // gg_cateco_posf_no_asz se non c'e' gg_integ_params

    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'qua2kd' => 'integer',
            'qua2ka' => 'integer',
            'refreshed_at' => 'datetime',
        ];
    }

    /**
     * @var array<int, string>
     */
    public array $valutaz_fields = ['esperienza_acquisita', 'risultati_ottenuti',
        'arricchimento_professionale', 'impegno', 'qualita_prestazione', ];

    /**
     * @var array<int, string>
     */
    public array $xls_fields = ['ente', 'matr', 'cognome', 'nome', 'propro', 'posfun', 'categoria_ecoval', 'posfunval', 'stabi', 'repar', 'anno',
        'email', 'esperienza_acquisita', 'risultati_ottenuti',
        'arricchimento_professionale', 'impegno', 'qualita_prestazione', 'totale', 'totale_pond', 'ha_diritto', 'motivo',
        'excellences_count_last_3_years',
    ];

    public int $n_perf_ind = 3;

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
}
