#!/usr/bin/env python3
"""Fix broken use function Safe class_uses lines introduced by convert-pest-to-assert.php"""
import re, os

broken_pattern = re.compile(r'use function Safe\x5cclass_uses\([^;]+\)uses;')
replacement = 'use function Safe' + chr(92) + 'class_uses;'

files = [
    'Modules/Cms/tests/Unit/Models/ConfBusinessLogicTest.php',
    'Modules/Cms/tests/Unit/Models/MenuBusinessLogicTest.php',
    'Modules/Cms/tests/Unit/Models/PageBusinessLogicTest.php',
    'Modules/Cms/tests/Unit/Models/SectionBusinessLogicTest.php',
    'Modules/Geo/tests/Unit/Models/ComuneBusinessLogicTest.php',
    'Modules/Geo/tests/Unit/Models/ProvinceBusinessLogicTest.php',
    'Modules/Geo/tests/Unit/Models/RegionBusinessLogicTest.php',
    'Modules/User/tests/Feature/Filament/Clusters/AppearanceClusterTest.php',
    'Modules/User/tests/Feature/Filament/Widgets/LoginWidgetTest.php',
    'Modules/User/tests/Unit/Actions/AdditionalActionsTest.php',
    'Modules/User/tests/Unit/Console/ConsoleCommandsTest.php',
    'Modules/User/tests/Unit/Datas/AdditionalDatasTest.php',
    'Modules/User/tests/Unit/Facades/FacadesTest.php',
    'Modules/User/tests/Unit/Mail/MailTest.php',
    'Modules/User/tests/Unit/Models/BaseUserTest.php',
    'Modules/User/tests/Unit/Models/PassportModelWrappersTest.php',
    'Modules/User/tests/Unit/Models/PassportWrapperConventionTest.php',
    'Modules/User/tests/Unit/Passport/PassportModelWrappersTest.php',
    'Modules/User/tests/Unit/Rules/RulesTest.php',
]

base = '/var/www/_bases/base_fixcity_fila5/laravel/'
fixed = 0
for rel in files:
    path = base + rel
    if not os.path.exists(path):
        print(f'MISSING: {rel}')
        continue
    content = open(path).read()
    new_content = broken_pattern.sub(lambda m: replacement, content)
    if new_content != content:
        open(path, 'w').write(new_content)
        fixed += 1
        print(f'FIXED: {rel}')
    else:
        print(f'no match: {rel}')
print(f'Total fixed: {fixed}')
