<?php
/**
 * @desc 配置文件
 * @author Tinywan(ShaoBo Wan)
 * @email 756684177@qq.com
 * @date 2022/9/11 15:56
 */

return [
    'enable' => true,

    // 算法类型 HS256、HS384、HS512、RS256、RS384、RS512、ES256、ES384、Ed25519
    'algorithms' => 'RS256',

    // access令牌秘钥
    'access_secret_key' => '2022d3d3LmJq',

    // access令牌过期时间，单位：秒。默认 2 小时
    'access_exp' => 7200,

    // 是否开启访问令牌强制提前过期
    'access_is_force' => false,

    // access令牌强制过期时间，默认和access令牌过期时间一致，如果想让已经发放的令牌提前过期，可以缩短该过期时间
    // 单位：秒。默认 2 小时
    'access_force_exp' => 7200,

    // refresh令牌秘钥
    'refresh_secret_key' => '2022KTxigxc9o50c',

    // refresh令牌过期时间，单位：秒。默认 7 天
    'refresh_exp' => 604800,

    // refresh令牌强制过期时间，默认和refresh令牌过期时间一致，如果想让已经发放的令牌提前过期，可以缩短该过期时间
    // 单位：秒。默认 2 小时
    'refresh_force_exp' => 604800,

    // refresh 令牌是否禁用，默认不禁用 false
    'refresh_disable' => false,

    // refresh 存储，该存储依赖于Redis
    'refresh_is_store' => false,

    // 令牌签发者
    'iss' => 'think.tinywan.cn',

    // 某个时间点后才能访问，单位秒。（如：30 表示当前时间30秒后才能使用）
    'nbf' => 60,

    // 时钟偏差冗余时间，单位秒。建议这个余地应该不大于几分钟。
    'leeway' => 60,

    // 单设备登录
    'is_single_device' => false,

    // 缓存令牌时间，单位：秒。默认 7 天
    'cache_token_ttl' => 604800,

    // 缓存令牌前缀
    'cache_token_pre' => 'JWT:TOKEN:',

    // 用户信息模型
    'user_model' => function($uid){
        return [];
    },

    /**
     * access令牌私钥
     */
    'access_private_key' => <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCv/ZwiPiwlW991
pOYP9GKyzODplsGXrBm/U7FgM2k8wCn+e96tboLMtwwD8vl7MZ6tM8F8QF7ipvfh
chDEtLmASW8kIaSPcEDYcO2brUDrbU8hPwiuPhuNTfmVDE9hWKr6ktq4q2c5nV79
Qby0eD0gyXK6ip0hHjmamMg8DrQDqGwt3Bn2hmVkK8Y9BQ0VQ6QWtjtYFV/0wGTY
emDkPtkJo25VsMwQKM6xZaEi//Oy7YIiQUv+328Sz/zJYjsIhreTCbR9g2QXFvHF
tH3v3OA3fgfLntrmPeG6WTCX9Sif0X9g8yusuQ9g8Vd7xWaZJ9wBWBLfZYmHPWIT
HCy/kchXAgMBAAECggEAZegnydhQfc2GRrwWj/SGVly2e+xU63u3aQeQdVEvxgLM
DlUx6yFL0jjIV10Rw5lG9ao7hrRLfVkLvlrrhMvVgoiDN9vXS0vH8MzrebLIHcss
/+ZdI3BJSfh15i27pXXPg8sXpclyu3T59RJkr+fUFbEwov3y4KN83Z1MjSJCcL7W
KSL12BgQMuqkZnOJUL6akWhf6Q8LbMoJHTkUoN755reZk/vdtE7qCaJWDW4CpP5b
/Q07m+cB+gR5/RiBabqHTPhEb7evIMeCvH2fdmMOe3mj1F3CQAT1VKIloPrxZK7c
Cr/KNQaB3115aMsxKOuc/nBzM8UOfDQTjqmysN01AQKBgQDnvHmuxqBRTA0nQ75b
B1KOU3tXlRNOW6U+fHA1Gma/vEHWFuFSApLtYa/me+RYkBEQRD/mlsMl5rFejlWG
DVeKOuKzTETJcHxW7ioSYfw7QACsqncxeoiTeOWw15XzmBExMO1xdqCjn45VVD9V
ilmqD35GzYbOlrwca3WYPLuJ1wKBgQDCauoQt7AAXNPf1AFo9fXrcg6bhFv30P4h
MMAAPL4uwZwQ7qcZEqk0bIFuJ+gkHI93re0LyVrsGxVJ2WEUyOoNPneHFcLN8Ya6
W9h0/CK8HXYkfpTk2Mm3ZmNy4twclDSuQ+kQeqRyOAZEccq9e2+m5eFsJEVmqwFF
NGU1wtzlgQKBgQDVUinNmuivjcu57mGH2EjF3dF4ATIherm1uMVuDNyy+bC9TJik
btwkCz3qdPfyEsSybbFJKlWASUnTmkDeQt/nzmcr2DSmHpdHSryN6YdQX41/ZPiO
Ipcg8jS2wu41rDF/T+P0A9jCZrmWkRQwQUhjBRogQUgsWpPVsZIxzw5wRwKBgBM/
MlzlUm82wWLvQhR6BRaB/CA5QkGOVxpCET/0w38te53Rgolg549hDo8xNDIfAbT/
avA3xuCI7dqZwpqkKUeWX47oAJkSyBu66/ro2yd0YzXJskPVkmKtqDq/arsJkQ2P
e4s+GPmVwkkUWtXXWn5TU7W5AYXgeAe54CsqV2QBAoGBAKkKCEbbSPXPf3VVssXT
ghcaeSXNvQpOCzCFkFhD3QohfZFcQ1b92LSeKZvLruboarogNYP/y/qB8BPTU90Q
ek6f8vIdgocb9xYxAfRHHpFZTrTGj8u6YGGAPBTJDHLx3W/u5qbJWpB50eUC8V/i
YEQ3yaUSmt953ME4JHsehUlA
-----END RSA PRIVATE KEY-----
EOD,

    /**
     * access令牌公钥
     */
    'access_public_key' => <<<EOD
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAr/2cIj4sJVvfdaTmD/Ri
sszg6ZbBl6wZv1OxYDNpPMAp/nverW6CzLcMA/L5ezGerTPBfEBe4qb34XIQxLS5
gElvJCGkj3BA2HDtm61A621PIT8Irj4bjU35lQxPYViq+pLauKtnOZ1e/UG8tHg9
IMlyuoqdIR45mpjIPA60A6hsLdwZ9oZlZCvGPQUNFUOkFrY7WBVf9MBk2Hpg5D7Z
CaNuVbDMECjOsWWhIv/zsu2CIkFL/t9vEs/8yWI7CIa3kwm0fYNkFxbxxbR979zg
N34Hy57a5j3hulkwl/Uon9F/YPMrrLkPYPFXe8VmmSfcAVgS32WJhz1iExwsv5HI
VwIDAQAB
-----END PUBLIC KEY-----
EOD,

    /**
     * refresh令牌私钥
     */
    'refresh_private_key' => <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCqIH//9wfdXkDF
ckOtXo1UwSUGJhNT0tZpLkvYSogNcK+krfqEbtCkjMu+gr8SWvZrRFgjkz/zL0BK
8ApNmWET5VtBBFfgBYZhXESizhgyaNPJjwhT7zzSe6Zr9LVILqQe16+P7TgI2QdI
AqHKeAwIcmpg1E7oFppZkcsf75qytIS8V/JPf9NstO1XFsuvPQorochOpr8NjW/l
xND2R3aVeCWb/WPIoC/84FvXTrXINpeCBSNzj+FLJ88Orvt/1hoaAG5miw//cq4q
wv+zk75n8KdAhXURZQ9VEBeqTusdY2odg2eWyQPMIAEmt5ZRCkB0idaHEe+MfRo9
hh/QH49FAgMBAAECggEATp0uCM3SKI0BSTv/4gErNdr6jNjTXYyz326xRYVLUUqd
H2/1r3S1nRQioiowuP6nl/HA+M92YZ2YDAjX+fvCTDtT67tiD/b9ncfRP5oUvFaM
ZztdEcwfQvQ4dvJhQrWqyUXJrqxjlFMVdkUhFjpa9RxJ4+y3ea/YK0OfpWZHCgR2
uSDGYfLlaSiYEE+X/rXgxJOOmns4JPaZD5l05MGGm4jnOHZy38xn8oF38e5XTOIF
cxcABU/06sl30C9pPoSQxEqHWJk9W9+7yL+RBQRep+vYlTyNghxH3fKYseibvtWt
Oum9oklasX/r40GHfyOB8wdD9s6AmFOkLgvbBnsfkQKBgQDo4sShiitgkkKBCRiP
JxBlfJFIVCRytNekOWDm/KK3dwRHm6699edTAhwySG3KJUGTItAGzjA/2CdZETal
EyrK8nu28d2vtWpiKbmKSulpNZxL+NPwefRpXI+No78vhpS5KgaN/tV09IPoxNH9
PfGX79mP0h9aMBYVsLPz+zLzHwKBgQC7AyLbWSaJIsGrw7MrIehHAByt+yt6OsMi
fLnlmDUIc23tNKLQgp/pQ1FHLv+uGl/QOPX9d7ErWafQfoIHqDuYqDexccOtIyNR
CcQpDbrWH76x5oEs9X5KypjCyzVNXNboQ7w2GzkR2CmXhvG2sHi2ZOTUmnwbX2jo
M0iCK8W1GwKBgQDfRgoelclgnNkFvSK+nEUsB3GCVqlbD+ZunFQ7IJsgKgsAXFH7
7XYKL0u5KZeY5n8oAYhP/f5kN2gCDG7HdMjiKfhSPTC89ME5u6cW3xtIsw1WCQmo
1ENvgD5hHUx+1BhiLdh66obbylFtKMXqdSja8ikzqdBFNzT1NqRQldUTIQKBgFao
uGFOqYXIvlg64m6tUrZ7/c49YsNMMZpsk7Qp2QFmg9z0lDHtJe7wy9whkkd6X0Xc
71iaO1YsQJBj3xtvQNaXtN8cKaG0c6wcy3J+s0KACVzkxJ0x0WkVAr7ZbYTA7bFJ
mhC0gribI4Lc/Gs80WMr08IVKEeC6dkX0pTHdeFbAoGAUtmPryMBGZ0J+JdvoH4Y
EjaEvCjntxp/zhJmstLyOtJ/D0DAMH4evb2UQMdvfzqCld8f7rn68muQHDnFM/T7
mATl1dw4b9e8nJ7Brxxc3tIpQ3wjYqAgwcK3x/w0moIu42HwR2RltxPtkGrzAVr7
Z70M8W5lY3MvxMiRrayMy9I=
-----END RSA PRIVATE KEY-----
EOD,

    /**
     * refresh令牌公钥
     */
    'refresh_public_key' => <<<EOD
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqiB///cH3V5AxXJDrV6N
VMElBiYTU9LWaS5L2EqIDXCvpK36hG7QpIzLvoK/Elr2a0RYI5M/8y9ASvAKTZlh
E+VbQQRX4AWGYVxEos4YMmjTyY8IU+880numa/S1SC6kHtevj+04CNkHSAKhyngM
CHJqYNRO6BaaWZHLH++asrSEvFfyT3/TbLTtVxbLrz0KK6HITqa/DY1v5cTQ9kd2
lXglm/1jyKAv/OBb1061yDaXggUjc4/hSyfPDq77f9YaGgBuZosP/3KuKsL/s5O+
Z/CnQIV1EWUPVRAXqk7rHWNqHYNnlskDzCABJreWUQpAdInWhxHvjH0aPYYf0B+P
RQIDAQAB
-----END PUBLIC KEY-----
EOD
];
