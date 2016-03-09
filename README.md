# okdokey-alive
서버의 상태를 실시간 모니터링할 수 있게 도와주는 서비스

install
----------

[composer](https://getcomposer.org/)

Configuration
-------------

`src/settings.php`를 수정해 필요한 환경변수들을 수정할 수 있다

`security` = API에 접근할 수 있도록 권한을 요청하는 암호 키

`network` = 서버의 네트워크 이름 ( default : p33p1, eth )

APIs
-----

#### POST /v1/auth/login
** request args **
서버의 상태를 반환받기 위해서 먼저 권한을 요청한다
name | type | description
---- | ---- | -----------
key | string | settings.php에서 설정한 security



#### DELETE /v1/auth/logout
** request args **
name | type | description
---- | ---- | -----------



#### GET /v1/proc
서버의 상태를 반환받는다

** request args **

name | type | description
---- | ---- | -----------


** response **

name | type | description
---- | ---- | -----------
cpu | float | cpu의 사용량을 % ( percentage )로 반환한다
uptime | float | 서버가 켜져있던 시간을 초단위로 반환한다
load | float | 서버 로드율을 1분, 5분, 15분 단위로 반환한다
disk | float | 디스크의 사용량을 % ( percentage )로 반환한다
memory | float | 메모리 사용량을 % ( percentage )로 반환한다
