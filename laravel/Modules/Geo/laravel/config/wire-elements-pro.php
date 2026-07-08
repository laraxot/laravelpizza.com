<?php

use App\CommandInsert;
use App\UserInsert;
use WireElements\Pro\Components\Modal\Resolvers\EnumPropertyResolver;
use WireElements\Pro\Icons\AcademicCap;
use WireElements\Pro\Icons\AdjustmentsHorizontal;
use WireElements\Pro\Icons\AdjustmentsVertical;
use WireElements\Pro\Icons\ArchiveBox;
use WireElements\Pro\Icons\ArchiveBoxArrowDown;
use WireElements\Pro\Icons\ArchiveBoxXMark;
use WireElements\Pro\Icons\ArrowDown;
use WireElements\Pro\Icons\ArrowDownCircle;
use WireElements\Pro\Icons\ArrowDownLeft;
use WireElements\Pro\Icons\ArrowDownOnSquare;
use WireElements\Pro\Icons\ArrowDownOnSquareStack;
use WireElements\Pro\Icons\ArrowDownRight;
use WireElements\Pro\Icons\ArrowDownTray;
use WireElements\Pro\Icons\ArrowLeft;
use WireElements\Pro\Icons\ArrowLeftCircle;
use WireElements\Pro\Icons\ArrowLeftOnRectangle;
use WireElements\Pro\Icons\ArrowLongDown;
use WireElements\Pro\Icons\ArrowLongLeft;
use WireElements\Pro\Icons\ArrowLongRight;
use WireElements\Pro\Icons\ArrowLongUp;
use WireElements\Pro\Icons\ArrowPath;
use WireElements\Pro\Icons\ArrowPathRoundedSquare;
use WireElements\Pro\Icons\ArrowRight;
use WireElements\Pro\Icons\ArrowRightCircle;
use WireElements\Pro\Icons\ArrowRightOnRectangle;
use WireElements\Pro\Icons\ArrowSmallDown;
use WireElements\Pro\Icons\ArrowSmallLeft;
use WireElements\Pro\Icons\ArrowSmallRight;
use WireElements\Pro\Icons\ArrowSmallUp;
use WireElements\Pro\Icons\ArrowsPointingIn;
use WireElements\Pro\Icons\ArrowsPointingOut;
use WireElements\Pro\Icons\ArrowsRightLeft;
use WireElements\Pro\Icons\ArrowsUpDown;
use WireElements\Pro\Icons\ArrowTopRightOnSquare;
use WireElements\Pro\Icons\ArrowTrendingDown;
use WireElements\Pro\Icons\ArrowTrendingUp;
use WireElements\Pro\Icons\ArrowUp;
use WireElements\Pro\Icons\ArrowUpCircle;
use WireElements\Pro\Icons\ArrowUpLeft;
use WireElements\Pro\Icons\ArrowUpOnSquare;
use WireElements\Pro\Icons\ArrowUpOnSquareStack;
use WireElements\Pro\Icons\ArrowUpRight;
use WireElements\Pro\Icons\ArrowUpTray;
use WireElements\Pro\Icons\ArrowUturnDown;
use WireElements\Pro\Icons\ArrowUturnLeft;
use WireElements\Pro\Icons\ArrowUturnRight;
use WireElements\Pro\Icons\ArrowUturnUp;
use WireElements\Pro\Icons\AtSymbol;
use WireElements\Pro\Icons\Backspace;
use WireElements\Pro\Icons\Backward;
use WireElements\Pro\Icons\Banknotes;
use WireElements\Pro\Icons\Bars2;
use WireElements\Pro\Icons\Bars3;
use WireElements\Pro\Icons\Bars3BottomLeft;
use WireElements\Pro\Icons\Bars3BottomRight;
use WireElements\Pro\Icons\Bars3CenterLeft;
use WireElements\Pro\Icons\Bars4;
use WireElements\Pro\Icons\BarsArrowDown;
use WireElements\Pro\Icons\BarsArrowUp;
use WireElements\Pro\Icons\Battery0;
use WireElements\Pro\Icons\Battery100;
use WireElements\Pro\Icons\Battery50;
use WireElements\Pro\Icons\Beaker;
use WireElements\Pro\Icons\Bell;
use WireElements\Pro\Icons\BellAlert;
use WireElements\Pro\Icons\BellSlash;
use WireElements\Pro\Icons\BellSnooze;
use WireElements\Pro\Icons\Bolt;
use WireElements\Pro\Icons\BoltSlash;
use WireElements\Pro\Icons\Bookmark;
use WireElements\Pro\Icons\BookmarkSlash;
use WireElements\Pro\Icons\BookmarkSquare;
use WireElements\Pro\Icons\BookOpen;
use WireElements\Pro\Icons\Briefcase;
use WireElements\Pro\Icons\BugAnt;
use WireElements\Pro\Icons\BuildingLibrary;
use WireElements\Pro\Icons\BuildingOffice;
use WireElements\Pro\Icons\BuildingOffice2;
use WireElements\Pro\Icons\BuildingStorefront;
use WireElements\Pro\Icons\Cake;
use WireElements\Pro\Icons\Calculator;
use WireElements\Pro\Icons\Calendar;
use WireElements\Pro\Icons\CalendarDays;
use WireElements\Pro\Icons\Camera;
use WireElements\Pro\Icons\ChartBar;
use WireElements\Pro\Icons\ChartBarSquare;
use WireElements\Pro\Icons\ChartPie;
use WireElements\Pro\Icons\ChatBubbleBottomCenter;
use WireElements\Pro\Icons\ChatBubbleBottomCenterText;
use WireElements\Pro\Icons\ChatBubbleLeft;
use WireElements\Pro\Icons\ChatBubbleLeftEllipsis;
use WireElements\Pro\Icons\ChatBubbleLeftRight;
use WireElements\Pro\Icons\ChatBubbleOvalLeft;
use WireElements\Pro\Icons\ChatBubbleOvalLeftEllipsis;
use WireElements\Pro\Icons\Check;
use WireElements\Pro\Icons\CheckBadge;
use WireElements\Pro\Icons\CheckCircle;
use WireElements\Pro\Icons\ChevronDoubleDown;
use WireElements\Pro\Icons\ChevronDoubleLeft;
use WireElements\Pro\Icons\ChevronDoubleRight;
use WireElements\Pro\Icons\ChevronDoubleUp;
use WireElements\Pro\Icons\ChevronDown;
use WireElements\Pro\Icons\ChevronLeft;
use WireElements\Pro\Icons\ChevronRight;
use WireElements\Pro\Icons\ChevronUp;
use WireElements\Pro\Icons\ChevronUpDown;
use WireElements\Pro\Icons\CircleStack;
use WireElements\Pro\Icons\Clipboard;
use WireElements\Pro\Icons\ClipboardDocument;
use WireElements\Pro\Icons\ClipboardDocumentCheck;
use WireElements\Pro\Icons\ClipboardDocumentList;
use WireElements\Pro\Icons\Clock;
use WireElements\Pro\Icons\Cloud;
use WireElements\Pro\Icons\CloudArrowDown;
use WireElements\Pro\Icons\CloudArrowUp;
use WireElements\Pro\Icons\CodeBracket;
use WireElements\Pro\Icons\CodeBracketSquare;
use WireElements\Pro\Icons\Cog;
use WireElements\Pro\Icons\Cog6Tooth;
use WireElements\Pro\Icons\Cog8Tooth;
use WireElements\Pro\Icons\CommandLine;
use WireElements\Pro\Icons\ComputerDesktop;
use WireElements\Pro\Icons\CpuChip;
use WireElements\Pro\Icons\CreditCard;
use WireElements\Pro\Icons\Cube;
use WireElements\Pro\Icons\CubeTransparent;
use WireElements\Pro\Icons\CurrencyBangladeshi;
use WireElements\Pro\Icons\CurrencyDollar;
use WireElements\Pro\Icons\CurrencyEuro;
use WireElements\Pro\Icons\CurrencyPound;
use WireElements\Pro\Icons\CurrencyRupee;
use WireElements\Pro\Icons\CurrencyYen;
use WireElements\Pro\Icons\CursorArrowRays;
use WireElements\Pro\Icons\CursorArrowRipple;
use WireElements\Pro\Icons\DevicePhoneMobile;
use WireElements\Pro\Icons\DeviceTablet;
use WireElements\Pro\Icons\Document;
use WireElements\Pro\Icons\DocumentArrowDown;
use WireElements\Pro\Icons\DocumentArrowUp;
use WireElements\Pro\Icons\DocumentChartBar;
use WireElements\Pro\Icons\DocumentCheck;
use WireElements\Pro\Icons\DocumentDuplicate;
use WireElements\Pro\Icons\DocumentMagnifyingGlass;
use WireElements\Pro\Icons\DocumentMinus;
use WireElements\Pro\Icons\DocumentPlus;
use WireElements\Pro\Icons\DocumentText;
use WireElements\Pro\Icons\EllipsisHorizontal;
use WireElements\Pro\Icons\EllipsisHorizontalCircle;
use WireElements\Pro\Icons\EllipsisVertical;
use WireElements\Pro\Icons\Envelope;
use WireElements\Pro\Icons\EnvelopeOpen;
use WireElements\Pro\Icons\ExclamationCircle;
use WireElements\Pro\Icons\ExclamationTriangle;
use WireElements\Pro\Icons\Eye;
use WireElements\Pro\Icons\EyeDropper;
use WireElements\Pro\Icons\EyeSlash;
use WireElements\Pro\Icons\FaceFrown;
use WireElements\Pro\Icons\FaceSmile;
use WireElements\Pro\Icons\Film;
use WireElements\Pro\Icons\FingerPrint;
use WireElements\Pro\Icons\Fire;
use WireElements\Pro\Icons\Flag;
use WireElements\Pro\Icons\Folder;
use WireElements\Pro\Icons\FolderArrowDown;
use WireElements\Pro\Icons\FolderMinus;
use WireElements\Pro\Icons\FolderOpen;
use WireElements\Pro\Icons\FolderPlus;
use WireElements\Pro\Icons\Forward;
use WireElements\Pro\Icons\Funnel;
use WireElements\Pro\Icons\Gif;
use WireElements\Pro\Icons\Gift;
use WireElements\Pro\Icons\GiftTop;
use WireElements\Pro\Icons\GlobeAlt;
use WireElements\Pro\Icons\GlobeAmericas;
use WireElements\Pro\Icons\GlobeAsiaAustralia;
use WireElements\Pro\Icons\GlobeEuropeAfrica;
use WireElements\Pro\Icons\HandRaised;
use WireElements\Pro\Icons\HandThumbDown;
use WireElements\Pro\Icons\HandThumbUp;
use WireElements\Pro\Icons\Hashtag;
use WireElements\Pro\Icons\Heart;
use WireElements\Pro\Icons\Home;
use WireElements\Pro\Icons\HomeModern;
use WireElements\Pro\Icons\Identification;
use WireElements\Pro\Icons\Inbox;
use WireElements\Pro\Icons\InboxArrowDown;
use WireElements\Pro\Icons\InboxStack;
use WireElements\Pro\Icons\InformationCircle;
use WireElements\Pro\Icons\Key;
use WireElements\Pro\Icons\Language;
use WireElements\Pro\Icons\Lifebuoy;
use WireElements\Pro\Icons\LightBulb;
use WireElements\Pro\Icons\Link;
use WireElements\Pro\Icons\ListBullet;
use WireElements\Pro\Icons\LockClosed;
use WireElements\Pro\Icons\LockOpen;
use WireElements\Pro\Icons\MagnifyingGlass;
use WireElements\Pro\Icons\MagnifyingGlassCircle;
use WireElements\Pro\Icons\MagnifyingGlassMinus;
use WireElements\Pro\Icons\MagnifyingGlassPlus;
use WireElements\Pro\Icons\Map;
use WireElements\Pro\Icons\MapPin;
use WireElements\Pro\Icons\Megaphone;
use WireElements\Pro\Icons\Microphone;
use WireElements\Pro\Icons\Minus;
use WireElements\Pro\Icons\MinusCircle;
use WireElements\Pro\Icons\MinusSmall;
use WireElements\Pro\Icons\Moon;
use WireElements\Pro\Icons\MusicalNote;
use WireElements\Pro\Icons\Newspaper;
use WireElements\Pro\Icons\NoSymbol;
use WireElements\Pro\Icons\PaintBrush;
use WireElements\Pro\Icons\PaperAirplane;
use WireElements\Pro\Icons\PaperClip;
use WireElements\Pro\Icons\Pause;
use WireElements\Pro\Icons\PauseCircle;
use WireElements\Pro\Icons\Pencil;
use WireElements\Pro\Icons\PencilSquare;
use WireElements\Pro\Icons\Phone;
use WireElements\Pro\Icons\PhoneArrowDownLeft;
use WireElements\Pro\Icons\PhoneArrowUpRight;
use WireElements\Pro\Icons\PhoneXMark;
use WireElements\Pro\Icons\Photo;
use WireElements\Pro\Icons\Play;
use WireElements\Pro\Icons\PlayCircle;
use WireElements\Pro\Icons\PlayPause;
use WireElements\Pro\Icons\Plus;
use WireElements\Pro\Icons\PlusCircle;
use WireElements\Pro\Icons\PlusSmall;
use WireElements\Pro\Icons\Power;
use WireElements\Pro\Icons\PresentationChartBar;
use WireElements\Pro\Icons\PresentationChartLine;
use WireElements\Pro\Icons\Printer;
use WireElements\Pro\Icons\PuzzlePiece;
use WireElements\Pro\Icons\QrCode;
use WireElements\Pro\Icons\QuestionMarkCircle;
use WireElements\Pro\Icons\QueueList;
use WireElements\Pro\Icons\Radio;
use WireElements\Pro\Icons\ReceiptPercent;
use WireElements\Pro\Icons\ReceiptRefund;
use WireElements\Pro\Icons\RectangleGroup;
use WireElements\Pro\Icons\RectangleStack;
use WireElements\Pro\Icons\RocketLaunch;
use WireElements\Pro\Icons\Rss;
use WireElements\Pro\Icons\Scale;
use WireElements\Pro\Icons\Scissors;
use WireElements\Pro\Icons\Server;
use WireElements\Pro\Icons\ServerStack;
use WireElements\Pro\Icons\Share;
use WireElements\Pro\Icons\ShieldCheck;
use WireElements\Pro\Icons\ShieldExclamation;
use WireElements\Pro\Icons\ShoppingBag;
use WireElements\Pro\Icons\ShoppingCart;
use WireElements\Pro\Icons\Signal;
use WireElements\Pro\Icons\SignalSlash;
use WireElements\Pro\Icons\Sparkles;
use WireElements\Pro\Icons\SpeakerWave;
use WireElements\Pro\Icons\SpeakerXMark;
use WireElements\Pro\Icons\Square2Stack;
use WireElements\Pro\Icons\Square3Stack3d;
use WireElements\Pro\Icons\Squares2x2;
use WireElements\Pro\Icons\SquaresPlus;
use WireElements\Pro\Icons\Star;
use WireElements\Pro\Icons\Stop;
use WireElements\Pro\Icons\StopCircle;
use WireElements\Pro\Icons\Sun;
use WireElements\Pro\Icons\Swatch;
use WireElements\Pro\Icons\TableCells;
use WireElements\Pro\Icons\Tag;
use WireElements\Pro\Icons\Ticket;
use WireElements\Pro\Icons\Trash;
use WireElements\Pro\Icons\Trophy;
use WireElements\Pro\Icons\Truck;
use WireElements\Pro\Icons\Tv;
use WireElements\Pro\Icons\User;
use WireElements\Pro\Icons\UserCircle;
use WireElements\Pro\Icons\UserGroup;
use WireElements\Pro\Icons\UserMinus;
use WireElements\Pro\Icons\UserPlus;
use WireElements\Pro\Icons\Users;
use WireElements\Pro\Icons\Variable;
use WireElements\Pro\Icons\VideoCamera;
use WireElements\Pro\Icons\VideoCameraSlash;
use WireElements\Pro\Icons\ViewColumns;
use WireElements\Pro\Icons\ViewfinderCircle;
use WireElements\Pro\Icons\Wallet;
use WireElements\Pro\Icons\Wifi;
use WireElements\Pro\Icons\Window;
use WireElements\Pro\Icons\Wrench;
use WireElements\Pro\Icons\WrenchScrewdriver;
use WireElements\Pro\Icons\XCircle;
use WireElements\Pro\Icons\XMark;

return [
    'default' => 'tailwind',

    'components' => [
        'modal' => [
            'view' => 'wire-elements-pro::modal.component',
            'property-resolvers' => [
                EnumPropertyResolver::class,
            ],
            'default-behavior' => [
                'close-on-escape' => true,
                'close-on-backdrop-click' => true,
                'trap-focus' => true,
                'remove-state-on-close' => false,
            ],
            'default-attributes' => [
                'size' => 'lg',
            ],
        ],
        'slide-over' => [
            'view' => 'wire-elements-pro::slide-over.component',
            'property-resolvers' => [
                EnumPropertyResolver::class,
            ],
            'default-behavior' => [
                'close-on-escape' => true,
                'close-on-backdrop-click' => true,
                'trap-focus' => true,
                'remove-state-on-close' => false,
            ],
            'default-attributes' => [
                'size' => 'md',
            ],
        ],
        'insert' => [
            'view' => 'wire-elements-pro::insert.component',
            'types' => [
                'user' => UserInsert::class,
                'command' => CommandInsert::class,
            ],
            'default-behavior' => [
                'debounce_milliseconds' => 200,
                'show_keyboard_instructions' => true,
            ],
        ],
        'spotlight' => [
            'view' => 'wire-elements-pro::spotlight.component',
            'default-behavior' => [
                'debounce_milliseconds' => 200,
                'shortcuts' => [
                    'k',
                    'slash',
                ],
            ],
        ],
    ],

    'presets' => [
        'tailwind' => [
            'modal' => [
                'size-map' => [
                    'xs' => 'max-w-xs',
                    'sm' => 'max-w-sm',
                    'md' => 'max-w-md',
                    'lg' => 'max-w-lg',
                    'xl' => 'max-w-xl',
                    '2xl' => 'max-w-2xl',
                    '3xl' => 'max-w-3xl',
                    '4xl' => 'max-w-4xl',
                    '5xl' => 'max-w-5xl',
                    '6xl' => 'max-w-6xl',
                    '7xl' => 'max-w-7xl',
                    'fullscreen' => 'fullscreen',
                ],
                'confirmation_view' => 'wire-elements-pro::modal.tailwind.confirmation',
            ],
            'slide-over' => [
                'size-map' => [
                    'xs' => 'max-w-xs',
                    'sm' => 'max-w-sm',
                    'md' => 'max-w-md',
                    'lg' => 'max-w-lg',
                    'xl' => 'max-w-xl',
                    '2xl' => 'max-w-2xl',
                    '3xl' => 'max-w-3xl',
                    '4xl' => 'max-w-4xl',
                    '5xl' => 'max-w-5xl',
                    '6xl' => 'max-w-6xl',
                    '7xl' => 'max-w-7xl',
                ],
            ],
        ],
        'bootstrap' => [
            'modal' => [
                'size-map' => [
                    'xs' => 'wep-modal-content-xs',
                    'sm' => 'wep-modal-content-sm',
                    'md' => 'wep-modal-content-md',
                    'lg' => 'wep-modal-content-lg',
                    'xl' => 'wep-modal-content-xl',
                    '2xl' => 'wep-modal-content-2xl',
                    '3xl' => 'wep-modal-content-3xl',
                    '4xl' => 'wep-modal-content-4xl',
                    '5xl' => 'wep-modal-content-5xl',
                    '6xl' => 'wep-modal-content-6xl',
                    '7xl' => 'wep-modal-content-7xl',
                    'fullscreen' => 'wep-modal-content-fullscreen',
                ],
                'confirmation_view' => 'wire-elements-pro::modal.bootstrap.confirmation',
            ],
            'slide-over' => [
                'size-map' => [
                    'xs' => 'wep-slide-over-content-xs',
                    'sm' => 'wep-slide-over-content-sm',
                    'md' => 'wep-slide-over-content-md',
                    'lg' => 'wep-slide-over-content-lg',
                    'xl' => 'wep-slide-over-content-xl',
                    '2xl' => 'wep-slide-over-content-2xl',
                    '3xl' => 'wep-slide-over-content-3xl',
                    '4xl' => 'wep-slide-over-content-4xl',
                    '5xl' => 'wep-slide-over-content-5xl',
                    '6xl' => 'wep-slide-over-content-6xl',
                    '7xl' => 'wep-slide-over-content-7xl',
                ],
            ],
        ],
    ],

    'icons' => [
        'academic-cap' => AcademicCap::class,
        'adjustments-horizontal' => AdjustmentsHorizontal::class,
        'adjustments-vertical' => AdjustmentsVertical::class,
        'archive-box-arrow-down' => ArchiveBoxArrowDown::class,
        'archive-box-x-mark' => ArchiveBoxXMark::class,
        'archive-box' => ArchiveBox::class,
        'arrow-down-circle' => ArrowDownCircle::class,
        'arrow-down-left' => ArrowDownLeft::class,
        'arrow-down-on-square-stack' => ArrowDownOnSquareStack::class,
        'arrow-down-on-square' => ArrowDownOnSquare::class,
        'arrow-down-right' => ArrowDownRight::class,
        'arrow-down-tray' => ArrowDownTray::class,
        'arrow-down' => ArrowDown::class,
        'arrow-left-circle' => ArrowLeftCircle::class,
        'arrow-left-on-rectangle' => ArrowLeftOnRectangle::class,
        'arrow-left' => ArrowLeft::class,
        'arrow-long-down' => ArrowLongDown::class,
        'arrow-long-left' => ArrowLongLeft::class,
        'arrow-long-right' => ArrowLongRight::class,
        'arrow-long-up' => ArrowLongUp::class,
        'arrow-path-rounded-square' => ArrowPathRoundedSquare::class,
        'arrow-path' => ArrowPath::class,
        'arrow-right-circle' => ArrowRightCircle::class,
        'arrow-right-on-rectangle' => ArrowRightOnRectangle::class,
        'arrow-right' => ArrowRight::class,
        'arrow-small-down' => ArrowSmallDown::class,
        'arrow-small-left' => ArrowSmallLeft::class,
        'arrow-small-right' => ArrowSmallRight::class,
        'arrow-small-up' => ArrowSmallUp::class,
        'arrow-top-right-on-square' => ArrowTopRightOnSquare::class,
        'arrow-trending-down' => ArrowTrendingDown::class,
        'arrow-trending-up' => ArrowTrendingUp::class,
        'arrow-up-circle' => ArrowUpCircle::class,
        'arrow-up-left' => ArrowUpLeft::class,
        'arrow-up-on-square-stack' => ArrowUpOnSquareStack::class,
        'arrow-up-on-square' => ArrowUpOnSquare::class,
        'arrow-up-right' => ArrowUpRight::class,
        'arrow-up-tray' => ArrowUpTray::class,
        'arrow-up' => ArrowUp::class,
        'arrow-uturn-down' => ArrowUturnDown::class,
        'arrow-uturn-left' => ArrowUturnLeft::class,
        'arrow-uturn-right' => ArrowUturnRight::class,
        'arrow-uturn-up' => ArrowUturnUp::class,
        'arrows-pointing-in' => ArrowsPointingIn::class,
        'arrows-pointing-out' => ArrowsPointingOut::class,
        'arrows-right-left' => ArrowsRightLeft::class,
        'arrows-up-down' => ArrowsUpDown::class,
        'at-symbol' => AtSymbol::class,
        'backspace' => Backspace::class,
        'backward' => Backward::class,
        'banknotes' => Banknotes::class,
        'bars-2' => Bars2::class,
        'bars-3-bottom-left' => Bars3BottomLeft::class,
        'bars-3-bottom-right' => Bars3BottomRight::class,
        'bars-3-center-left' => Bars3CenterLeft::class,
        'bars-3' => Bars3::class,
        'bars-4' => Bars4::class,
        'bars-arrow-down' => BarsArrowDown::class,
        'bars-arrow-up' => BarsArrowUp::class,
        'battery-0' => Battery0::class,
        'battery-100' => Battery100::class,
        'battery-50' => Battery50::class,
        'beaker' => Beaker::class,
        'bell-alert' => BellAlert::class,
        'bell-slash' => BellSlash::class,
        'bell-snooze' => BellSnooze::class,
        'bell' => Bell::class,
        'bolt-slash' => BoltSlash::class,
        'bolt' => Bolt::class,
        'book-open' => BookOpen::class,
        'bookmark-slash' => BookmarkSlash::class,
        'bookmark-square' => BookmarkSquare::class,
        'bookmark' => Bookmark::class,
        'briefcase' => Briefcase::class,
        'bug-ant' => BugAnt::class,
        'building-library' => BuildingLibrary::class,
        'building-office-2' => BuildingOffice2::class,
        'building-office' => BuildingOffice::class,
        'building-storefront' => BuildingStorefront::class,
        'cake' => Cake::class,
        'calculator' => Calculator::class,
        'calendar-days' => CalendarDays::class,
        'calendar' => Calendar::class,
        'camera' => Camera::class,
        'chart-bar-square' => ChartBarSquare::class,
        'chart-bar' => ChartBar::class,
        'chart-pie' => ChartPie::class,
        'chat-bubble-bottom-center-text' => ChatBubbleBottomCenterText::class,
        'chat-bubble-bottom-center' => ChatBubbleBottomCenter::class,
        'chat-bubble-left-ellipsis' => ChatBubbleLeftEllipsis::class,
        'chat-bubble-left-right' => ChatBubbleLeftRight::class,
        'chat-bubble-left' => ChatBubbleLeft::class,
        'chat-bubble-oval-left-ellipsis' => ChatBubbleOvalLeftEllipsis::class,
        'chat-bubble-oval-left' => ChatBubbleOvalLeft::class,
        'check-badge' => CheckBadge::class,
        'check-circle' => CheckCircle::class,
        'check' => Check::class,
        'chevron-double-down' => ChevronDoubleDown::class,
        'chevron-double-left' => ChevronDoubleLeft::class,
        'chevron-double-right' => ChevronDoubleRight::class,
        'chevron-double-up' => ChevronDoubleUp::class,
        'chevron-down' => ChevronDown::class,
        'chevron-left' => ChevronLeft::class,
        'chevron-right' => ChevronRight::class,
        'chevron-up-down' => ChevronUpDown::class,
        'chevron-up' => ChevronUp::class,
        'circle-stack' => CircleStack::class,
        'clipboard-document-check' => ClipboardDocumentCheck::class,
        'clipboard-document-list' => ClipboardDocumentList::class,
        'clipboard-document' => ClipboardDocument::class,
        'clipboard' => Clipboard::class,
        'clock' => Clock::class,
        'cloud-arrow-down' => CloudArrowDown::class,
        'cloud-arrow-up' => CloudArrowUp::class,
        'cloud' => Cloud::class,
        'code-bracket-square' => CodeBracketSquare::class,
        'code-bracket' => CodeBracket::class,
        'cog-6-tooth' => Cog6Tooth::class,
        'cog-8-tooth' => Cog8Tooth::class,
        'cog' => Cog::class,
        'command-line' => CommandLine::class,
        'computer-desktop' => ComputerDesktop::class,
        'cpu-chip' => CpuChip::class,
        'credit-card' => CreditCard::class,
        'cube-transparent' => CubeTransparent::class,
        'cube' => Cube::class,
        'currency-bangladeshi' => CurrencyBangladeshi::class,
        'currency-dollar' => CurrencyDollar::class,
        'currency-euro' => CurrencyEuro::class,
        'currency-pound' => CurrencyPound::class,
        'currency-rupee' => CurrencyRupee::class,
        'currency-yen' => CurrencyYen::class,
        'cursor-arrow-rays' => CursorArrowRays::class,
        'cursor-arrow-ripple' => CursorArrowRipple::class,
        'device-phone-mobile' => DevicePhoneMobile::class,
        'device-tablet' => DeviceTablet::class,
        'document-arrow-down' => DocumentArrowDown::class,
        'document-arrow-up' => DocumentArrowUp::class,
        'document-chart-bar' => DocumentChartBar::class,
        'document-check' => DocumentCheck::class,
        'document-duplicate' => DocumentDuplicate::class,
        'document-magnifying-glass' => DocumentMagnifyingGlass::class,
        'document-minus' => DocumentMinus::class,
        'document-plus' => DocumentPlus::class,
        'document-text' => DocumentText::class,
        'document' => Document::class,
        'ellipsis-horizontal-circle' => EllipsisHorizontalCircle::class,
        'ellipsis-horizontal' => EllipsisHorizontal::class,
        'ellipsis-vertical' => EllipsisVertical::class,
        'envelope-open' => EnvelopeOpen::class,
        'envelope' => Envelope::class,
        'exclamation-circle' => ExclamationCircle::class,
        'exclamation-triangle' => ExclamationTriangle::class,
        'eye-dropper' => EyeDropper::class,
        'eye-slash' => EyeSlash::class,
        'eye' => Eye::class,
        'face-frown' => FaceFrown::class,
        'face-smile' => FaceSmile::class,
        'film' => Film::class,
        'finger-print' => FingerPrint::class,
        'fire' => Fire::class,
        'flag' => Flag::class,
        'folder-arrow-down' => FolderArrowDown::class,
        'folder-minus' => FolderMinus::class,
        'folder-open' => FolderOpen::class,
        'folder-plus' => FolderPlus::class,
        'folder' => Folder::class,
        'forward' => Forward::class,
        'funnel' => Funnel::class,
        'gif' => Gif::class,
        'gift-top' => GiftTop::class,
        'gift' => Gift::class,
        'globe-alt' => GlobeAlt::class,
        'globe-americas' => GlobeAmericas::class,
        'globe-asia-australia' => GlobeAsiaAustralia::class,
        'globe-europe-africa' => GlobeEuropeAfrica::class,
        'hand-raised' => HandRaised::class,
        'hand-thumb-down' => HandThumbDown::class,
        'hand-thumb-up' => HandThumbUp::class,
        'hashtag' => Hashtag::class,
        'heart' => Heart::class,
        'home-modern' => HomeModern::class,
        'home' => Home::class,
        'identification' => Identification::class,
        'inbox-arrow-down' => InboxArrowDown::class,
        'inbox-stack' => InboxStack::class,
        'inbox' => Inbox::class,
        'information-circle' => InformationCircle::class,
        'key' => Key::class,
        'language' => Language::class,
        'lifebuoy' => Lifebuoy::class,
        'light-bulb' => LightBulb::class,
        'link' => Link::class,
        'list-bullet' => ListBullet::class,
        'lock-closed' => LockClosed::class,
        'lock-open' => LockOpen::class,
        'magnifying-glass-circle' => MagnifyingGlassCircle::class,
        'magnifying-glass-minus' => MagnifyingGlassMinus::class,
        'magnifying-glass-plus' => MagnifyingGlassPlus::class,
        'magnifying-glass' => MagnifyingGlass::class,
        'map-pin' => MapPin::class,
        'map' => Map::class,
        'megaphone' => Megaphone::class,
        'microphone' => Microphone::class,
        'minus-circle' => MinusCircle::class,
        'minus-small' => MinusSmall::class,
        'minus' => Minus::class,
        'moon' => Moon::class,
        'musical-note' => MusicalNote::class,
        'newspaper' => Newspaper::class,
        'no-symbol' => NoSymbol::class,
        'paint-brush' => PaintBrush::class,
        'paper-airplane' => PaperAirplane::class,
        'paper-clip' => PaperClip::class,
        'pause-circle' => PauseCircle::class,
        'pause' => Pause::class,
        'pencil-square' => PencilSquare::class,
        'pencil' => Pencil::class,
        'phone-arrow-down-left' => PhoneArrowDownLeft::class,
        'phone-arrow-up-right' => PhoneArrowUpRight::class,
        'phone-x-mark' => PhoneXMark::class,
        'phone' => Phone::class,
        'photo' => Photo::class,
        'play-circle' => PlayCircle::class,
        'play-pause' => PlayPause::class,
        'play' => Play::class,
        'plus-circle' => PlusCircle::class,
        'plus-small' => PlusSmall::class,
        'plus' => Plus::class,
        'power' => Power::class,
        'presentation-chart-bar' => PresentationChartBar::class,
        'presentation-chart-line' => PresentationChartLine::class,
        'printer' => Printer::class,
        'puzzle-piece' => PuzzlePiece::class,
        'qr-code' => QrCode::class,
        'question-mark-circle' => QuestionMarkCircle::class,
        'queue-list' => QueueList::class,
        'radio' => Radio::class,
        'receipt-percent' => ReceiptPercent::class,
        'receipt-refund' => ReceiptRefund::class,
        'rectangle-group' => RectangleGroup::class,
        'rectangle-stack' => RectangleStack::class,
        'rocket-launch' => RocketLaunch::class,
        'rss' => Rss::class,
        'scale' => Scale::class,
        'scissors' => Scissors::class,
        'server-stack' => ServerStack::class,
        'server' => Server::class,
        'share' => Share::class,
        'shield-check' => ShieldCheck::class,
        'shield-exclamation' => ShieldExclamation::class,
        'shopping-bag' => ShoppingBag::class,
        'shopping-cart' => ShoppingCart::class,
        'signal-slash' => SignalSlash::class,
        'signal' => Signal::class,
        'sparkles' => Sparkles::class,
        'speaker-wave' => SpeakerWave::class,
        'speaker-x-mark' => SpeakerXMark::class,
        'square-2-stack' => Square2Stack::class,
        'square-3-stack-3d' => Square3Stack3d::class,
        'squares-2x2' => Squares2x2::class,
        'squares-plus' => SquaresPlus::class,
        'star' => Star::class,
        'stop-circle' => StopCircle::class,
        'stop' => Stop::class,
        'sun' => Sun::class,
        'swatch' => Swatch::class,
        'table-cells' => TableCells::class,
        'tag' => Tag::class,
        'ticket' => Ticket::class,
        'trash' => Trash::class,
        'trophy' => Trophy::class,
        'truck' => Truck::class,
        'tv' => Tv::class,
        'user-circle' => UserCircle::class,
        'user-group' => UserGroup::class,
        'user-minus' => UserMinus::class,
        'user-plus' => UserPlus::class,
        'user' => User::class,
        'users' => Users::class,
        'variable' => Variable::class,
        'video-camera-slash' => VideoCameraSlash::class,
        'video-camera' => VideoCamera::class,
        'view-columns' => ViewColumns::class,
        'viewfinder-circle' => ViewfinderCircle::class,
        'wallet' => Wallet::class,
        'wifi' => Wifi::class,
        'window' => Window::class,
        'wrench-screwdriver' => WrenchScrewdriver::class,
        'wrench' => Wrench::class,
        'x-circle' => XCircle::class,
        'x-mark' => XMark::class,
    ],
];
