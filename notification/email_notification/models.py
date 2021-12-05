from django.db import models

class Notification(models.Model):
    id = models.BigAutoField(primary_key=True)
    user_id = models.CharField(max_length=200)
    date = models.CharField(max_length=200)

    _disable_kafka_signals = False

    def save(self, *args, **kwargs):
        ret = super().save(*args, **kwargs)

        return ret