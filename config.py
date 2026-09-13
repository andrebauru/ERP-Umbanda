import os
from datetime import timedelta

class Config:
    """Configuração base da aplicação"""
    SQLALCHEMY_DATABASE_URI = os.getenv('DATABASE_URL', 'sqlite:///erp_umbanda.db')
    SQLALCHEMY_TRACK_MODIFICATIONS = False
    SECRET_KEY = os.getenv('SECRET_KEY', 'sua-chave-secreta-muito-segura-aqui-2024')
    
    # Configurações de sessão
    PERMANENT_SESSION_LIFETIME = timedelta(hours=8)
    SESSION_REFRESH_EACH_REQUEST = True
    
    # Configurações de segurança
    SESSION_COOKIE_SECURE = True
    SESSION_COOKIE_HTTPONLY = True
    SESSION_COOKIE_SAMESITE = 'Lax'
    
    # Configuração do terreiro
    ORGANIZATION_NAME = "Terreiro Dourado do Oriente - Tempo de Exu Mirim"
    PRIVACY_NOTICE = "Os dados aqui visualizados são sigilosos e não serão sujeitos à lei de privacidade do Japão"
    
class DevelopmentConfig(Config):
    """Configuração de desenvolvimento"""
    DEBUG = True
    TESTING = False
    SESSION_COOKIE_SECURE = False

class ProductionConfig(Config):
    """Configuração de produção"""
    DEBUG = False
    TESTING = False

class TestingConfig(Config):
    """Configuração de testes"""
    DEBUG = True
    TESTING = True
    SQLALCHEMY_DATABASE_URI = 'sqlite:///:memory:'

config = {
    'development': DevelopmentConfig,
    'production': ProductionConfig,
    'testing': TestingConfig,
    'default': DevelopmentConfig
}
