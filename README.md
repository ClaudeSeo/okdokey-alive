# okdokey-alive
###### 실시간 내 서버의 상태를 볼 수 있게 도와주는 어플리케이션

Slim(PHP), Android Project

현재 내 서버의 상태가 궁금할 때 어플리케이션을 실행하면 CPU, RAM, DISK의 사용량을 계산하여 보여준다


### 설치
[Slim](http://www.slimframework.com/) 설치 후 웹서버와 연동

### Configuration
`src/settings.php`를 수정해 필요한 환경 변수들을 수정할 수 있다

- `security` : API에 접근할 수 있는 암호키

- `network` : 트래픽량을 감시할 이더넷 ( default p33p1 )

### APIs
##### POST /v1/auth/login
서버의 상태를 반환받기 위해서 먼저 권한을 요청한다

**request params**

name | type | description
---- | ---- | -----------
key | string | settings.php에서 설정한 security
<br>

##### DELETE /v1/auth/logout
API호출을 위한 권한을 반환한다

<br>

##### GET /v1/proc
서버의 상태를 반환받는다

**response**

name | type | description
--- | --- | -----------
cpu | float | cpu의 사용량을 % ( percentage )로 반환한다
uptime | float | 서버가 켜져있던 시간을 초단위로 반환한다
load | float | 서버 로드율을 1분, 5분, 15분 단위로 반환한다
disk | float | 디스크의 사용량을 % ( percentage )로 반환한다
memory | float | 메모리 사용량을 % ( percentage )로 반환한다
