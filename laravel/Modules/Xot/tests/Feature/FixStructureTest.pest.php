|<|?|p|h|p|
|
|d|e|c|l|a|r|e|(|s|t|r|i|c|t|_|t|y|p|e|s|=|1|)|;|
|
|n|a|m|e|s|p|a|c|e| |M|o|d|u|l|e|s||X|o|t||T|e|s|t|s||F|e|a|t|u|r|e|;|
|
|u|s|e| |M|o|d|u|l|e|s||X|o|t||T|e|s|t|s||T|e|s|t|C|a|s|e|;|
|
|u|s|e|s|(|T|e|s|t|C|a|s|e|:|:|c|l|a|s|s|)|;|
|
|b|e|f|o|r|e|E|a|c|h|(|f|u|n|c|t|i|o|n| |(|)| |{|
| | | | |/|/| |C|r|e|a|t|e| |a| |t|e|m|p|o|r|a|r|y| |d|i|r|e|c|t|o|r|y| |f|o|r| |t|e|s|t|i|n|g|
| | | | |$|t|h|i|s|-|>|t|e|s|t|D|i|r| |=| |s|y|s|_|g|e|t|_|t|e|m|p|_|d|i|r|(|)|.|'|/|f|i|x|_|s|t|r|u|c|t|u|r|e|_|t|e|s|t|_|'|.|u|n|i|q|i|d|(|)|;|
| | | | |m|k|d|i|r|(|$|t|h|i|s|-|>|t|e|s|t|D|i|r|,| |0|o|7|5|5|,| |t|r|u|e|)|;|
|
| | | | |/|/| |S|e|t| |t|h|e| |w|o|r|k|i|n|g| |d|i|r|e|c|t|o|r|y|
| | | | |c|h|d|i|r|(|$|t|h|i|s|-|>|t|e|s|t|D|i|r|)|;|
|}|)|;|
|
|a|f|t|e|r|E|a|c|h|(|f|u|n|c|t|i|o|n| |(|)| |{|
| | | | |/|/| |C|l|e|a|n| |u|p| |t|h|e| |t|e|s|t| |d|i|r|e|c|t|o|r|y|
| | | | |$|t|h|i|s|-|>|r|r|m|d|i|r|(|$|t|h|i|s|-|>|t|e|s|t|D|i|r|)|;|
|}|)|;|
|
|/|/| |R|e|c|u|r|s|i|v|e| |f|u|n|c|t|i|o|n| |t|o| |r|e|m|o|v|e| |a| |d|i|r|e|c|t|o|r|y| |a|n|d| |i|t|s| |c|o|n|t|e|n|t|s|
|f|u|n|c|t|i|o|n| |r|r|m|d|i|r|(|$|d|i|r|)|
|{|
| | | | |i|f| |(|i|s|_|d|i|r|(|$|d|i|r|)|)| |{|
| | | | | | | | |$|o|b|j|e|c|t|s| |=| |s|c|a|n|d|i|r|(|$|d|i|r|)|;|
| | | | | | | | |f|o|r|e|a|c|h| |(|$|o|b|j|e|c|t|s| |a|s| |$|o|b|j|e|c|t|)| |{|
| | | | | | | | | | | | |i|f| |(|'|.|'| |!|=|=| |$|o|b|j|e|c|t| |&|&| |'|.|.|'| |!|=|=| |$|o|b|j|e|c|t|)| |{|
| | | | | | | | | | | | | | | | |i|f| |(|i|s|_|d|i|r|(|$|d|i|r|.|D|I|R|E|C|T|O|R|Y|_|S|E|P|A|R|A|T|O|R|.|$|o|b|j|e|c|t|)| |&|&| |!| |i|s|_|l|i|n|k|(|$|d|i|r|.|'|/|'|.|$|o|b|j|e|c|t|)|)| |{|
| | | | | | | | | | | | | | | | | | | | |r|r|m|d|i|r|(|$|d|i|r|.|D|I|R|E|C|T|O|R|Y|_|S|E|P|A|R|A|T|O|R|.|$|o|b|j|e|c|t|)|;|
| | | | | | | | | | | | | | | | |}| |e|l|s|e| |{|
| | | | | | | | | | | | | | | | | | | | |u|n|l|i|n|k|(|$|d|i|r|.|D|I|R|E|C|T|O|R|Y|_|S|E|P|A|R|A|T|O|R|.|$|o|b|j|e|c|t|)|;|
| | | | | | | | | | | | | | | | |}|
| | | | | | | | | | | | |}|
| | | | | | | | |}|
| | | | | | | | |r|m|d|i|r|(|$|d|i|r|)|;|
| | | | |}|
|}|
|
|t|e|s|t|(|'|c|r|e|a|t|e|s| |n|e|c|e|s|s|a|r|y| |d|i|r|e|c|t|o|r|i|e|s| |a|n|d| |f|i|l|e|s|'|,| |f|u|n|c|t|i|o|n| |(|)| |{|
| | | | |/|/| |R|u|n| |t|h|e| |c|o|m|m|a|n|d|
| | | | |$|t|h|i|s|-|>|a|r|t|i|s|a|n|(|'|x|o|t|:|f|i|x|-|s|t|r|u|c|t|u|r|e|'|)|-|>|a|s|s|e|r|t|E|x|i|t|C|o|d|e|(|0|)|;|
|
| | | | |/|/| |C|h|e|c|k| |i|f| |d|i|r|e|c|t|o|r|i|e|s| |w|e|r|e| |c|r|e|a|t|e|d|
| | | | |$|d|i|r|e|c|t|o|r|i|e|s| |=| |[|
| | | | | | | | |'|a|p|p|/|M|o|d|e|l|s|'|,|
| | | | | | | | |'|a|p|p|/|H|t|t|p|/|C|o|n|t|r|o|l|l|e|r|s|'|,|
| | | | | | | | |'|a|p|p|/|H|t|t|p|/|R|e|q|u|e|s|t|s|'|,|
| | | | | | | | |'|a|p|p|/|H|t|t|p|/|R|e|s|o|u|r|c|e|s|'|,|
| | | | | | | | |'|a|p|p|/|H|t|t|p|/|M|i|d|d|l|e|w|a|r|e|'|,|
| | | | | | | | |'|a|p|p|/|P|r|o|v|i|d|e|r|s|'|,|
| | | | | | | | |'|d|a|t|a|b|a|s|e|/|m|i|g|r|a|t|i|o|n|s|'|,|
| | | | | | | | |'|d|a|t|a|b|a|s|e|/|s|e|e|d|e|r|s|'|,|
| | | | | | | | |'|d|a|t|a|b|a|s|e|/|f|a|c|t|o|r|i|e|s|'|,|
| | | | | | | | |'|r|e|s|o|u|r|c|e|s|/|v|i|e|w|s|'|,|
| | | | | | | | |'|r|o|u|t|e|s|'|,|
| | | | | | | | |'|t|e|s|t|s|/|F|e|a|t|u|r|e|'|,|
| | | | | | | | |'|t|e|s|t|s|/|U|n|i|t|'|,|
| | | | |]|;|
|
| | | | |f|o|r|e|a|c|h| |(|$|d|i|r|e|c|t|o|r|i|e|s| |a|s| |$|d|i|r|e|c|t|o|r|y|)| |{|
| | | | | | | | |$|t|h|i|s|-|>|a|s|s|e|r|t|D|i|r|e|c|t|o|r|y|E|x|i|s|t|s|(|$|t|h|i|s|-|>|t|e|s|t|D|i|r|.|'|/|'|.|$|d|i|r|e|c|t|o|r|y|)|;|
| | | | |}|
|
| | | | |/|/| |C|h|e|c|k| |i|f| |.|g|i|t|k|e|e|p| |f|i|l|e|s| |w|e|r|e| |c|r|e|a|t|e|d| |i|n| |e|m|p|t|y| |d|i|r|e|c|t|o|r|i|e|s|
| | | | |$|g|i|t|k|e|e|p|F|i|l|e|s| |=| |[|
| | | | | | | | |'|a|p|p|/|M|o|d|e|l|s|/|.|g|i|t|k|e|e|p|'|,|
| | | | | | | | |'|a|p|p|/|H|t|t|p|/|C|o|n|t|r|o|l|l|e|r|s|/|.|g|i|t|k|e|e|p|'|,|
| | | | | | | | |'|a|p|p|/|H|t|t|p|/|R|e|q|u|e|s|t|s|/|.|g|i|t|k|e|e|p|'|,|
| | | | | | | | |'|a|p|p|/|H|t|t|p|/|R|e|s|o|u|r|c|e|s|/|.|g|i|t|k|e|e|p|'|,|
| | | | | | | | |'|d|a|t|a|b|a|s|e|/|s|e|e|d|e|r|s|/|.|g|i|t|k|e|e|p|'|,|
| | | | | | | | |'|r|e|s|o|u|r|c|e|s|/|v|i|e|w|s|/|.|g|i|t|k|e|e|p|'|,|
| | | | |]|;|
|
| | | | |f|o|r|e|a|c|h| |(|$|g|i|t|k|e|e|p|F|i|l|e|s| |a|s| |$|f|i|l|e|)| |{|
| | | | | | | | |$|t|h|i|s|-|>|a|s|s|e|r|t|F|i|l|e|E|x|i|s|t|s|(|$|t|h|i|s|-|>|t|e|s|t|D|i|r|.|'|/|'|.|$|f|i|l|e|)|;|
| | | | |}|
|}|)|;|
|
|t|e|s|t|(|'|d|o|e|s| |n|o|t| |o|v|e|r|w|r|i|t|e| |e|x|i|s|t|i|n|g| |f|i|l|e|s|'|,| |f|u|n|c|t|i|o|n| |(|)| |{|
| | | | |/|/| |C|r|e|a|t|e| |a| |t|e|s|t| |f|i|l|e| |t|h|a|t| |s|h|o|u|l|d| |n|o|t| |b|e| |o|v|e|r|w|r|i|t|t|e|n|
| | | | |$|t|e|s|t|C|o|n|t|e|n|t| |=| |'|T|e|s|t| |c|o|n|t|e|n|t|'|;|
| | | | |$|t|e|s|t|F|i|l|e| |=| |$|t|h|i|s|-|>|t|e|s|t|D|i|r|.|'|/|r|o|u|t|e|s|/|w|e|b|.|p|h|p|'|;|
| | | | |f|i|l|e|_|p|u|t|_|c|o|n|t|e|n|t|s|(|$|t|e|s|t|F|i|l|e|,| |$|t|e|s|t|C|o|n|t|e|n|t|)|;|
|
| | | | |/|/| |R|u|n| |t|h|e| |c|o|m|m|a|n|d|
| | | | |$|t|h|i|s|-|>|a|r|t|i|s|a|n|(|'|x|o|t|:|f|i|x|-|s|t|r|u|c|t|u|r|e|'|)|-|>|a|s|s|e|r|t|E|x|i|t|C|o|d|e|(|0|)|;|
|
| | | | |/|/| |V|e|r|i|f|y| |t|h|e| |f|i|l|e| |w|a|s| |n|o|t| |o|v|e|r|w|r|i|t|t|e|n|
| | | | |$|t|h|i|s|-|>|a|s|s|e|r|t|S|t|r|i|n|g|E|q|u|a|l|s|F|i|l|e|(|$|t|e|s|t|F|i|l|e|,| |$|t|e|s|t|C|o|n|t|e|n|t|)|;|
|}|)|;|
|
|t|e|s|t|(|'|h|a|n|d|l|e|s| |e|r|r|o|r|s| |g|r|a|c|e|f|u|l|l|y|'|,| |f|u|n|c|t|i|o|n| |(|)| |{|
| | | | |/|/| |M|a|k|e| |a| |d|i|r|e|c|t|o|r|y| |n|o|n|-|w|r|i|t|a|b|l|e| |t|o| |t|e|s|t| |e|r|r|o|r| |h|a|n|d|l|i|n|g|
| | | | |$|n|o|n|W|r|i|t|a|b|l|e|D|i|r| |=| |$|t|h|i|s|-|>|t|e|s|t|D|i|r|.|'|/|a|p|p|'|;|
| | | | |c|h|m|o|d|(|$|n|o|n|W|r|i|t|a|b|l|e|D|i|r|,| |0|o|5|5|5|)|;|
|
| | | | |/|/| |R|u|n| |t|h|e| |c|o|m|m|a|n|d| |a|n|d| |e|x|p|e|c|t| |a|n| |e|r|r|o|r|
| | | | |$|t|h|i|s|-|>|a|r|t|i|s|a|n|(|'|x|o|t|:|f|i|x|-|s|t|r|u|c|t|u|r|e|'|)|-|>|a|s|s|e|r|t|E|x|i|t|C|o|d|e|(|1|)|;|
|
| | | | |/|/| |R|e|s|t|o|r|e| |p|e|r|m|i|s|s|i|o|n|s|
| | | | |c|h|m|o|d|(|$|n|o|n|W|r|i|t|a|b|l|e|D|i|r|,| |0|o|7|5|5|)|;|
|}|)|;|
|