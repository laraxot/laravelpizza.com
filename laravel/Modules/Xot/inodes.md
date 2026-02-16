--------------------------------------------------------------
$ df -i /
Filesystem      Inodes  IUsed   IFree    IUse% Mounted on
/dev/xvda1      7692288 652294 7039994    9%      /

--------------------------------------------------------------
$ sudo find / -xdev -printf '%h\0' | sort -z | uniq -cz | sort -nrzk 1 | tr '\0' '\n' | head -n 50

-------------------------------------------------------------------
abbastanza veloce
$ find . -xdev -type f | cut -d "/" -f 2 | sort | uniq -c | sort -n

-- current directory total inodes
$find .  -xdev -printf '%h\n' | sort | uniq -c | awk '{total = total + $1}END{print total}'

--------------------------------------------------------------
$ echo "Detailed Inode usage for: $(pwd)" ; for d in `find -maxdepth 1 -type d |cut -d\/ -f2 |grep -xv . |sort`; do c=$(find $d |wc -l) ; printf "$c\t\t- $d\n" ; done ; printf "Total: \t\t$(find $(pwd) | wc -l)\n"

--------------------------------------------------------------
Per vedere quanto spazio su disco occupa il file di log si può usare il comando:

$ journalctl --disk-usage

--------------------------------------------------------------
Per ridurre rapidamente le dimensioni su disco ci sono due vie la prima quella di decidere di mantenere soltanto un dato numero di file di journal, per cui verranno cancellati i file più vecchi ad eccezione dei tot più recenti.
Lanciando per esempio il comando:

$ journalctl --vacuum-files=4
Conserveremo esclusivamente gli ultimi 4 file.

--------------------------------------------------------------
Se il comando sopra non fosse disponibile, per ridurre le dimensioni del file di log si può usare anche il comando:

$ journalctl --vacuum-size=100M
dove 100M sono le dimensioni in cui il file di log deve stare ossia verranno scartiti tutti i log più vecchi finchè non si raggiunge uno spazio di disco usato da Jorunal di 100M (o meno).

--------------------------------------------------------------

