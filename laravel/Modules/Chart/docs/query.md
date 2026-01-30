---
title: Query
description: Query
extends: _layouts.documentation
section: content
---

# Query {#query-chart}

Modules/Quaeris/Actions/Question/GetAnswersByQuestionDataAction.php è l'azione che prende le risposte per i grafici dai vari question type.

si può mettere un dddx($class) per vedere che classe usa

Le query per fare i grafici possono essere ad esempio:

```mysql
select
    lime_survey_657328.id,
    lime_survey_657328.submitdate,
    lime_survey_657328.token,
    657328X660X28949SQ002 as _key,
    ask_lang.answer as _value,
    DATE_FORMAT(submitdate, "%Y-%b") as _group_by,
    null as _group_by_value,
    DATE_FORMAT(submitdate, "%Y-%m") as _sort_by,
    657328X660X28864 as _key1,
    ask2_lang.answer as _value1,
    null as _subs,
    AVG(ask_lang.answer) AS value,
    count(ask_lang.answer) AS value1
from
    `lime_survey_657328`
    
    left join `lime_answers` as `ask0` on `ask0`.`qid` = 28949
    and `ask0`.`code` = 657328X660X28949SQ002

    left join `lime_answer_l10ns` as `ask_lang` on `ask_lang`.`aid` = `ask0`.`aid`
    and `ask_lang`.`language` = 'it'

    left join `lime_answers` as `ask2` on `ask2`.`qid` = 28864
    and `ask2`.`code` = 657328X660X28864

    left join `lime_answer_l10ns` as `ask2_lang` on `ask2_lang`.`aid` = `ask2`.`aid`
    and `ask2_lang`.`language` = 'it'
where
    `submitdate` is not null
    and `657328X660X28949SQ002` is not null
    and concat('', ask_lang.answer * 1) = ask_lang.answer
group by
    `_group_by`,
    `_key1`
order by
    `_sort_by` asc
```

La query è scomponibile in varie parti per controllare:

Esempio:

```mysql
select
    lime_survey_657328.id,
    lime_survey_657328.submitdate,
    lime_survey_657328.token,
    /*657328X660X28949SQ002 as _key,*/
    ask_lang.answer as _value,
    657328X660X28864 as _key1,
    ask2_lang.answer as _value1,
    /*AVG(ask_lang.answer) AS value*/
from
    `lime_survey_657328`
    left join `lime_answers` as `ask0` on `ask0`.`qid` = 28949
    and `ask0`.`code` = 657328X660X28949SQ002
    left join `lime_answer_l10ns` as `ask_lang` on `ask_lang`.`aid` = `ask0`.`aid`
    and `ask_lang`.`language` = 'it'
    left join `lime_answers` as `ask2` on `ask2`.`qid` = 28864
    and `ask2`.`code` = 657328X660X28864
    left join `lime_answer_l10ns` as `ask2_lang` on `ask2_lang`.`aid` = `ask2`.`aid`
    and `ask2_lang`.`language` = 'it'
where
    `submitdate` like '2022-10-%'
    and ask2_lang.answer = 'BELLUNO'
    and `657328X660X28949SQ002` is not null
    and concat('', ask_lang.answer * 1) = ask_lang.answer
```

In questo caso avremo un $answer con value (media) e values (valori da cui calcola la media)