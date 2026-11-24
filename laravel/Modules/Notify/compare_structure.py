from bs4 import BeautifulSoup
import sys

def clean_soup(soup):
    for script in soup(["script", "style"]):
        script.extract()
    return soup

def get_structure(file_path):
    with open(file_path, 'r') as f:
        soup = BeautifulSoup(f, 'html.parser')
    body = soup.find('body')
    if not body:
        return "No body found"
    body = clean_soup(body)
    return body.prettify()

ref_struct = get_structure('reference.html')
loc_struct = get_structure('local.html')

with open('ref_struct.txt', 'w') as f:
    f.write(ref_struct)
with open('loc_struct.txt', 'w') as f:
    f.write(loc_struct)

print("Structure files generated: ref_struct.txt and loc_struct.txt")
