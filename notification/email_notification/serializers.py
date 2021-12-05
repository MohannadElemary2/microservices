from rest_framework import serializers
from . import models

class NotificationSerializer(serializers.ModelSerializer):
    VERSION = 1
    KEY_FIELD = "user_id"
    MESSAGE_TYPE = 'user'

    class Meta:
        model = models.Notification
        fields = ["user_id", "date"]

    @classmethod
    def lookup_instance(cls, user_id, **kwargs):
        try:
            notification = models.Notification.objects.get(user_id=user_id)
            return notification
        except models.Notification.DoesNotExist:
            pass