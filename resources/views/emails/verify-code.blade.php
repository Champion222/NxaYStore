@php
    $brand = $brand ?? config('app.brand', []);
    $brandName = $brand['name'] ?? config('app.name');
    $brandAccent = $brand['accent'] ?? '';
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Email Verification Code</title>
</head>

<body style="margin:0;padding:0;background:#ffffff;color:#0f172a;font-family:Arial, sans-serif;">
    <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="padding:32px 16px;">
                <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="max-width:520px;">
                    <tr>
                        <td style="background:#ffffff;border-radius:16px;padding:28px;border:1px solid #e2e8f0;">
                            <h1 style="margin:0 0 8px 0;font-size:22px;color:#f8fafc;">
                                {{ $brandName }}{{ $brandAccent }}
                            </h1>
                            <p style="margin:0 0 18px 0;color:#475569;font-size:14px;">
                                Use the code below to verify your email.
                            </p>
                            <div
                                style="background:#f1f5f9;border-radius:12px;padding:16px;text-align:center;letter-spacing:6px;font-size:24px;font-weight:bold;color:#0f172a;">
                                {{ $code }}
                            </div>
                            <p style="margin:18px 0 0 0;color:#64748b;font-size:12px;">
                                This code expires in {{ $expiresIn }} minutes.
                            </p>
                            <p style="margin:10px 0 0 0;color:#64748b;font-size:12px;">
                                If you didn't request this, you can ignore this email.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
