# LastHeard maintenance

HBMonv2 records completed calls in `log/lastheard.log`. The supplied
`lastheard` script retains the latest 250 lines and safely does nothing before
the first log is created.

Install it as a daily task:

```sh
cp /opt/HBMonv2/utils/lastheard /etc/cron.daily/lastheard
chmod +x /etc/cron.daily/lastheard
```

The default file is `/opt/HBMonv2/log/lastheard.log`. To use another location,
set `LASTHEARD_LOG` in the cron environment before invoking the script.

The long list is available at `https://YOUR_HOST/log.php` and refreshes every
30 seconds. Change the refresh value in `html/log.php` if required.

Thanks to Heiko DL1BZ, who shared the original LastHeard code.
