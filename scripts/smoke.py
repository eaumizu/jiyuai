import json
import urllib.request

base = 'http://localhost:8080'

def get(path):
    with urllib.request.urlopen(base + path, timeout=30) as response:
        assert response.status == 200
        return response.read().decode()

assert '自由な発想を、かたちに。' in get('/')
assert 'ブログ' in get('/?pagename=blog')
app = get('/?pagename=apps')
assert 'ここから Web アプリの機能を追加できます。' in app
assert '[jiyuai_app]' not in app
pages = json.loads(get('/?rest_route=/wp/v2/pages'))
assert {'home', 'blog', 'apps'} <= {page['slug'] for page in pages}
posts = json.loads(get('/?rest_route=/wp/v2/posts'))
assert isinstance(posts, list)
assert 'user_login' in get('/wp-login.php')
print('PASS: home, blog, app shortcode, REST pages/posts, login (6 checks)')
