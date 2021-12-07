from django.core.management.base import BaseCommand
from kafka import KafkaConsumer
from email_notification import constants
import json
from django.conf import settings
from email_notification.models import Notification
from django.core.mail import send_mail

class Command(BaseCommand):
    help = 'Fetch and apply Kafka messages'

    def handle(self, *args, **options):
        consumer = KafkaConsumer(constants.TOPIC_EMAIL_NOTIFICATIONS, 
            bootstrap_servers=[settings.KAFKA_BOOTSTRAP_SERVER], 
            api_version=(0, 10)
        )

        for message in consumer:
            deserialized_data = json.loads(message.value)

            notification = Notification(
                user_id=deserialized_data['user_id'],
                date=deserialized_data['date']
            )
            notification.save()

            send_mail(
                'Welcome To Our Site!',
                'Hello ' + deserialized_data['name'],
                settings.EMAIL_HOST_USER,
                [deserialized_data['email']],
                fail_silently=False,
            )
            