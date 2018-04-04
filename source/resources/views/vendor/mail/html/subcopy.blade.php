<table class="subcopy" style="box-sizing: border-box; color: #3f3f3f; line-height: 15px; font-size: 11px; font-family: arial, verdana, sans-serif; background-color: #FFFFFF; margin: 0 auto; padding: 0; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px;" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            {{ Illuminate\Mail\Markdown::parse($slot) }}
        </td>
    </tr>
</table>
