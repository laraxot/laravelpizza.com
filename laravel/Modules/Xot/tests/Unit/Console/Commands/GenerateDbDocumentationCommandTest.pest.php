|<|?|p|h|p|
|
|d|e|c|l|a|r|e|(|s|t|r|i|c|t|_|t|y|p|e|s|=|1|)|;|
|
|n|a|m|e|s|p|a|c|e| |M|o|d|u|l|e|s||X|o|t||T|e|s|t|s||U|n|i|t||C|o|n|s|o|l|e||C|o|m|m|a|n|d|s|;|
|
|u|s|e| |I|l|l|u|m|i|n|a|t|e||S|u|p|p|o|r|t||F|a|c|a|d|e|s||A|r|t|i|s|a|n|;|
|u|s|e| |I|l|l|u|m|i|n|a|t|e||S|u|p|p|o|r|t||F|a|c|a|d|e|s||F|i|l|e|;|
|u|s|e| |M|o|d|u|l|e|s||X|o|t||T|e|s|t|s||T|e|s|t|C|a|s|e|;|
|
|u|s|e|s|(|T|e|s|t|C|a|s|e|:|:|c|l|a|s|s|)|;|
|
|b|e|f|o|r|e|E|a|c|h|(|f|u|n|c|t|i|o|n| |(|)| |{|
| | | | |$|t|h|i|s|-|>|t|e|s|t|S|c|h|e|m|a|P|a|t|h| |=| |s|t|o|r|a|g|e|_|p|a|t|h|(|'|t|e|s|t|s|/|s|c|h|e|m|a|.|j|s|o|n|'|)|;|
| | | | |$|t|h|i|s|-|>|t|e|s|t|O|u|t|p|u|t|D|i|r| |=| |s|t|o|r|a|g|e|_|p|a|t|h|(|'|t|e|s|t|s|/|d|o|c|s|'|)|;|
|
| | | | |/|/| |C|r|e|a|t|e| |t|e|s|t| |d|i|r|e|c|t|o|r|y| |i|f| |i|t| |d|o|e|s|n|'|t| |e|x|i|s|t|
| | | | |i|f| |(|!| |F|i|l|e|:|:|e|x|i|s|t|s|(||d|i|r|n|a|m|e|(|$|t|h|i|s|-|>|t|e|s|t|S|c|h|e|m|a|P|a|t|h|)|)|)| |{|
| | | | | | | | |F|i|l|e|:|:|m|a|k|e|D|i|r|e|c|t|o|r|y|(||d|i|r|n|a|m|e|(|$|t|h|i|s|-|>|t|e|s|t|S|c|h|e|m|a|P|a|t|h|)|,| |0|o|7|5|5|,| |t|r|u|e|)|;|
| | | | |}|
|
| | | | |/|/| |C|r|e|a|t|e| |a| |t|e|s|t| |s|c|h|e|m|a| |f|i|l|e|
| | | | |$|t|e|s|t|S|c|h|e|m|a| |=| |[|
| | | | | | | | |'|d|a|t|a|b|a|s|e|'| |=|>| |'|t|e|s|t|_|d|b|'|,|
| | | | | | | | |'|c|o|n|n|e|c|t|i|o|n|'| |=|>| |'|m|y|s|q|l|'|,|
| | | | | | | | |'|t|a|b|l|e|s|'| |=|>| |[|
| | | | | | | | | | | | |'|u|s|e|r|s|'| |=|>| |[|
| | | | | | | | | | | | | | | | |'|c|o|l|u|m|n|s|'| |=|>| |[|
| | | | | | | | | | | | | | | | | | | | |'|i|d|'| |=|>| |[|
| | | | | | | | | | | | | | | | | | | | | | | | |'|t|y|p|e|'| |=|>| |'|b|i|g|i|n|t|'|,|
| | | | | | | | | | | | | | | | | | | | | | | | |'|n|u|l|l|a|b|l|e|'| |=|>| |f|a|l|s|e|,|
| | | | | | | | | | | | | | | | | | | | | | | | |'|d|e|f|a|u|l|t|'| |=|>| |n|u|l|l|,|
| | | | | | | | | | | | | | | | | | | | | | | | |'|e|x|t|r|a|'| |=|>| |'|a|u|t|o|_|i|n|c|r|e|m|e|n|t|'|,|
| | | | | | | | | | | | | | | | | | | | |]|,|
| | | | | | | | | | | | | | | | | | | | |'|n|a|m|e|'| |=|>| |[|
| | | | | | | | | | | | | | | | | | | | | | | | |'|t|y|p|e|'| |=|>| |'|v|a|r|c|h|a|r|(|2|5|5|)|'|,|
| | | | | | | | | | | | | | | | | | | | | | | | |'|n|u|l|l|a|b|l|e|'| |=|>| |f|a|l|s|e|,|
| | | | | | | | | | | | | | | | | | | | | | | | |'|d|e|f|a|u|l|t|'| |=|>| |n|u|l|l|,|
| | | | | | | | | | | | | | | | | | | | |]|,|
| | | | | | | | | | | | | | | | |]|,|
| | | | | | | | | | | | | | | | |'|p|r|i|m|a|r|y|_|k|e|y|'| |=|>| |[|
| | | | | | | | | | | | | | | | | | | | |'|c|o|l|u|m|n|s|'| |=|>| |[|'|i|d|'|]|,|
| | | | | | | | | | | | | | | | |]|,|
| | | | | | | | | | | | | | | | |'|i|n|d|e|x|e|s|'| |=|>| |[|
| | | | | | | | | | | | | | | | | | | | |'|n|a|m|e|_|i|n|d|e|x|'| |=|>| |[|
| | | | | | | | | | | | | | | | | | | | | | | | |'|c|o|l|u|m|n|s|'| |=|>| |[|'|n|a|m|e|'|]|,|
| | | | | | | | | | | | | | | | | | | | | | | | |'|t|y|p|e|'| |=|>| |'|i|n|d|e|x|'|,|
| | | | | | | | | | | | | | | | | | | | |]|,|
| | | | | | | | | | | | | | | | |]|,|
| | | | | | | | | | | | | | | | |'|f|o|r|e|i|g|n|_|k|e|y|s|'| |=|>| |[|]|,|
| | | | | | | | | | | | | | | | |'|r|e|c|o|r|d|_|c|o|u|n|t|'| |=|>| |1|0|,|
| | | | | | | | | | | | |]|,|
| | | | | | | | |]|,|
| | | | | | | | |'|r|e|l|a|t|i|o|n|s|h|i|p|s|'| |=|>| |[|]|,|
| | | | |]|;|
|
| | | | |f|i|l|e|_|p|u|t|_|c|o|n|t|e|n|t|s|(|$|t|h|i|s|-|>|t|e|s|t|S|c|h|e|m|a|P|a|t|h|,| |j|s|o|n|_|e|n|c|o|d|e|(|$|t|e|s|t|S|c|h|e|m|a|,| |J|S|O|N|_|P|R|E|T|T|Y|_|P|R|I|N|T|)|)|;|
|
| | | | |/|/| |E|n|s|u|r|e| |o|u|t|p|u|t| |d|i|r|e|c|t|o|r|y| |i|s| |c|l|e|a|n|
| | | | |i|f| |(|F|i|l|e|:|:|e|x|i|s|t|s|(|$|t|h|i|s|-|>|t|e|s|t|O|u|t|p|u|t|D|i|r|)|)| |{|
| | | | | | | | |F|i|l|e|:|:|d|e|l|e|t|e|D|i|r|e|c|t|o|r|y|(|$|t|h|i|s|-|>|t|e|s|t|O|u|t|p|u|t|D|i|r|)|;|
| | | | |}|
|}|)|;|
|
|a|f|t|e|r|E|a|c|h|(|f|u|n|c|t|i|o|n| |(|)| |{|
| | | | |/|/| |C|l|e|a|n| |u|p| |t|e|s|t| |f|i|l|e|s|
| | | | |i|f| |(|F|i|l|e|:|:|e|x|i|s|t|s|(|$|t|h|i|s|-|>|t|e|s|t|S|c|h|e|m|a|P|a|t|h|)|)| |{|
| | | | | | | | |F|i|l|e|:|:|d|e|l|e|t|e|(|$|t|h|i|s|-|>|t|e|s|t|S|c|h|e|m|a|P|a|t|h|)|;|
| | | | |}|
| | | | |i|f| |(|F|i|l|e|:|:|e|x|i|s|t|s|(|$|t|h|i|s|-|>|t|e|s|t|O|u|t|p|u|t|D|i|r|)|)| |{|
| | | | | | | | |F|i|l|e|:|:|d|e|l|e|t|e|D|i|r|e|c|t|o|r|y|(|$|t|h|i|s|-|>|t|e|s|t|O|u|t|p|u|t|D|i|r|)|;|
| | | | |}|
|}|)|;|
|
|t|e|s|t|(|'|i|t| |g|e|n|e|r|a|t|e|s| |d|a|t|a|b|a|s|e| |d|o|c|u|m|e|n|t|a|t|i|o|n|'|,| |f|u|n|c|t|i|o|n| |(|)| |{|
| | | | |/|/| |R|u|n| |t|h|e| |c|o|m|m|a|n|d|
| | | | |$|e|x|i|t|C|o|d|e| |=| |A|r|t|i|s|a|n|:|:|c|a|l|l|(|'|x|o|t|:|g|e|n|e|r|a|t|e|-|d|b|-|d|o|c|u|m|e|n|t|a|t|i|o|n|'|,| |[|
| | | | | | | | |'|-|-|s|c|h|e|m|a|'| |=|>| |$|t|h|i|s|-|>|t|e|s|t|S|c|h|e|m|a|P|a|t|h|,|
| | | | | | | | |'|-|-|o|u|t|p|u|t|'| |=|>| |$|t|h|i|s|-|>|t|e|s|t|O|u|t|p|u|t|D|i|r|,|
| | | | |]|)|;|
|
| | | | |/|/| |A|s|s|e|r|t| |c|o|m|m|a|n|d| |w|a|s| |s|u|c|c|e|s|s|f|u|l|
| | | | |e|x|p|e|c|t|(|$|e|x|i|t|C|o|d|e|)|-|>|t|o|B|e|(|0|)|;|
|
| | | | |/|/| |C|h|e|c|k| |i|f| |o|u|t|p|u|t| |f|i|l|e|s| |w|e|r|e| |c|r|e|a|t|e|d|
| | | | |e|x|p|e|c|t|(|F|i|l|e|:|:|e|x|i|s|t|s|(|$|t|h|i|s|-|>|t|e|s|t|O|u|t|p|u|t|D|i|r|.|'|/|d|a|t|a|b|a|s|e|-|d|o|c|u|m|e|n|t|a|t|i|o|n|.|m|d|'|)|)|
| | | | | | | | |-|>|t|o|B|e|T|r|u|e|(|)|
| | | | | | | | |-|>|a|n|d|(|F|i|l|e|:|:|e|x|i|s|t|s|(|$|t|h|i|s|-|>|t|e|s|t|O|u|t|p|u|t|D|i|r|.|'|/|t|a|b|l|e|s|/|u|s|e|r|s|.|m|d|'|)|)|
| | | | | | | | |-|>|t|o|B|e|T|r|u|e|(|)|;|
|}|)|;|
|
|t|e|s|t|(|'|i|t| |h|a|n|d|l|e|s| |m|i|s|s|i|n|g| |s|c|h|e|m|a| |f|i|l|e|'|,| |f|u|n|c|t|i|o|n| |(|)| |{|
| | | | |/|/| |D|e|l|e|t|e| |t|h|e| |s|c|h|e|m|a| |f|i|l|e|
| | | | |F|i|l|e|:|:|d|e|l|e|t|e|(|$|t|h|i|s|-|>|t|e|s|t|S|c|h|e|m|a|P|a|t|h|)|;|
|
| | | | |/|/| |R|u|n| |t|h|e| |c|o|m|m|a|n|d| |a|n|d| |e|x|p|e|c|t| |a|n| |e|r|r|o|r|
| | | | |$|e|x|i|t|C|o|d|e| |=| |A|r|t|i|s|a|n|:|:|c|a|l|l|(|'|x|o|t|:|g|e|n|e|r|a|t|e|-|d|b|-|d|o|c|u|m|e|n|t|a|t|i|o|n|'|,| |[|
| | | | | | | | |'|-|-|s|c|h|e|m|a|'| |=|>| |$|t|h|i|s|-|>|t|e|s|t|S|c|h|e|m|a|P|a|t|h|,|
| | | | | | | | |'|-|-|o|u|t|p|u|t|'| |=|>| |$|t|h|i|s|-|>|t|e|s|t|O|u|t|p|u|t|D|i|r|,|
| | | | |]|)|;|
|
| | | | |/|/| |A|s|s|e|r|t| |c|o|m|m|a|n|d| |f|a|i|l|e|d|
| | | | |e|x|p|e|c|t|(|$|e|x|i|t|C|o|d|e|)|-|>|n|o|t|-|>|t|o|B|e|(|0|)|;|
|}|)|;|
|
|t|e|s|t|(|'|i|t| |h|a|n|d|l|e|s| |i|n|v|a|l|i|d| |s|c|h|e|m|a| |f|i|l|e|'|,| |f|u|n|c|t|i|o|n| |(|)| |{|
| | | | |/|/| |W|r|i|t|e| |i|n|v|a|l|i|d| |J|S|O|N| |t|o| |t|h|e| |s|c|h|e|m|a| |f|i|l|e|
| | | | |f|i|l|e|_|p|u|t|_|c|o|n|t|e|n|t|s|(|$|t|h|i|s|-|>|t|e|s|t|S|c|h|e|m|a|P|a|t|h|,| |'|i|n|v|a|l|i|d| |j|s|o|n|'|)|;|
|
| | | | |/|/| |R|u|n| |t|h|e| |c|o|m|m|a|n|d| |a|n|d| |e|x|p|e|c|t| |a|n| |e|r|r|o|r|
| | | | |$|e|x|i|t|C|o|d|e| |=| |A|r|t|i|s|a|n|:|:|c|a|l|l|(|'|x|o|t|:|g|e|n|e|r|a|t|e|-|d|b|-|d|o|c|u|m|e|n|t|a|t|i|o|n|'|,| |[|
| | | | | | | | |'|-|-|s|c|h|e|m|a|'| |=|>| |$|t|h|i|s|-|>|t|e|s|t|S|c|h|e|m|a|P|a|t|h|,|
| | | | | | | | |'|-|-|o|u|t|p|u|t|'| |=|>| |$|t|h|i|s|-|>|t|e|s|t|O|u|t|p|u|t|D|i|r|,|
| | | | |]|)|;|
|
| | | | |/|/| |A|s|s|e|r|t| |c|o|m|m|a|n|d| |f|a|i|l|e|d|
| | | | |e|x|p|e|c|t|(|$|e|x|i|t|C|o|d|e|)|-|>|n|o|t|-|>|t|o|B|e|(|0|)|;|
|}|)|;|
|
|t|e|s|t|(|'|i|t| |h|a|n|d|l|e|s| |m|i|s|s|i|n|g| |o|u|t|p|u|t| |d|i|r|e|c|t|o|r|y|'|,| |f|u|n|c|t|i|o|n| |(|)| |{|
| | | | |/|/| |D|e|l|e|t|e| |t|h|e| |o|u|t|p|u|t| |d|i|r|e|c|t|o|r|y| |i|f| |i|t| |e|x|i|s|t|s|
| | | | |i|f| |(|F|i|l|e|:|:|e|x|i|s|t|s|(|$|t|h|i|s|-|>|t|e|s|t|O|u|t|p|u|t|D|i|r|)|)| |{|
| | | | | | | | |F|i|l|e|:|:|d|e|l|e|t|e|D|i|r|e|c|t|o|r|y|(|$|t|h|i|s|-|>|t|e|s|t|O|u|t|p|u|t|D|i|r|)|;|
| | | | |}|
|
| | | | |/|/| |R|u|n| |t|h|e| |c|o|m|m|a|n|d|
| | | | |$|e|x|i|t|C|o|d|e| |=| |A|r|t|i|s|a|n|:|:|c|a|l|l|(|'|x|o|t|:|g|e|n|e|r|a|t|e|-|d|b|-|d|o|c|u|m|e|n|t|a|t|i|o|n|'|,| |[|
| | | | | | | | |'|-|-|s|c|h|e|m|a|'| |=|>| |$|t|h|i|s|-|>|t|e|s|t|S|c|h|e|m|a|P|a|t|h|,|
| | | | | | | | |'|-|-|o|u|t|p|u|t|'| |=|>| |$|t|h|i|s|-|>|t|e|s|t|O|u|t|p|u|t|D|i|r|,|
| | | | |]|)|;|
|
| | | | |/|/| |A|s|s|e|r|t| |c|o|m|m|a|n|d| |w|a|s| |s|u|c|c|e|s|s|f|u|l| |a|n|d| |c|r|e|a|t|e|d| |t|h|e| |o|u|t|p|u|t| |d|i|r|e|c|t|o|r|y|
| | | | |e|x|p|e|c|t|(|$|e|x|i|t|C|o|d|e|)|-|>|t|o|B|e|(|0|)|-|>|a|n|d|(|F|i|l|e|:|:|i|s|D|i|r|e|c|t|o|r|y|(|$|t|h|i|s|-|>|t|e|s|t|O|u|t|p|u|t|D|i|r|)|)|-|>|t|o|B|e|T|r|u|e|(|)|;|
|}|)|;|
|