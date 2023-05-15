# kw_semaphore

[![Build Status](https://app.travis-ci.com/alex-kalanis/kw_semaphore.svg?branch=master)](https://app.travis-ci.com/github/alex-kalanis/kw_semaphore)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/alex-kalanis/kw_semaphore/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/alex-kalanis/kw_semaphore/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/alex-kalanis/kw_semaphore/v/stable.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_semaphore)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.3-8892BF.svg)](https://php.net/)
[![Downloads](https://img.shields.io/packagist/dt/alex-kalanis/kw_semaphore.svg?v1)](https://packagist.org/packages/alex-kalanis/kw_semaphore)
[![License](https://poser.pugx.org/alex-kalanis/kw_semaphore/license.svg?v=1)](https://packagist.org/packages/alex-kalanis/kw_semaphore)
[![Code Coverage](https://scrutinizer-ci.com/g/alex-kalanis/kw_semaphore/badges/coverage.png?b=master&v=1)](https://scrutinizer-ci.com/g/alex-kalanis/kw_semaphore/?branch=master)

Simple semaphore to determine if some element did something.

## PHP Installation

```
{
    "require": {
        "alex-kalanis/kw_semaphore": "1.0"
    }
}
```

(Refer to [Composer Documentation](https://github.com/composer/composer/blob/master/doc/00-intro.md#introduction) if you are not
familiar with composer)


## PHP Usage

1.) Use your autoloader (if not already done via Composer autoloader)

2.) Add some external packages with connection to the local or remote services.

3.) Connect the "kalanis\kw_semaphore\Semaphore\*" into your app. Extends it for setting your case.

4.) Extend your libraries by interfaces inside the package.

5.) Just call setting and render
