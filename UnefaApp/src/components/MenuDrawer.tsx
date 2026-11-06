import React from 'react';
import { View, Text, StyleSheet, Modal, Pressable, ScrollView } from 'react-native';
import { Image } from 'expo-image';
import { useRouter } from 'expo-router';
import { UnefaColors } from '@/constants/theme';
import { X, ArrowRight } from 'lucide-react-native';

interface MenuDrawerProps {
  visible: boolean;
  onClose: () => void;
  onNavigateSection?: (sectionId: string) => void;
}

export function MenuDrawer({ visible, onClose, onNavigateSection }: MenuDrawerProps) {
  const router = useRouter();

  const handleLink = (section: string) => {
    onClose();
    if (onNavigateSection) {
      onNavigateSection(section);
    }
  };

  return (
    <Modal visible={visible} transparent animationType="slide" onRequestClose={onClose}>
      <View style={styles.backdrop}>
        <Pressable style={styles.dismissOverlay} onPress={onClose} />
        <View style={styles.sheet}>
          <View style={styles.header}>
            <View style={styles.brand}>
              <View style={styles.logoWrap}>
                <Image
                  source={require('@/assets/images/unefa-logo.png')}
                  style={styles.logo}
                  contentFit="contain"
                />
              </View>
              <View>
                <Text style={styles.brandName}>UNEFA</Text>
                <Text style={styles.brandSub}>Menú institucional</Text>
              </View>
            </View>
            <Pressable style={styles.closeBtn} onPress={onClose}>
              <X size={18} color="#0f172a" strokeWidth={2.5} />
            </Pressable>
          </View>

          <ScrollView style={styles.content} showsVerticalScrollIndicator={false}>
            <View style={styles.navLinks}>
              <Pressable style={styles.navLink} onPress={() => handleLink('inicio')}>
                <Text style={styles.idx}>[01]</Text>
                <Text style={styles.navText}>Inicio</Text>
                <ArrowRight size={16} color={UnefaColors.gold} strokeWidth={2.5} />
              </Pressable>

              <Pressable style={styles.navLink} onPress={() => handleLink('nosotros')}>
                <Text style={styles.idx}>[02]</Text>
                <Text style={styles.navText}>Doctrina</Text>
                <ArrowRight size={16} color={UnefaColors.gold} strokeWidth={2.5} />
              </Pressable>

              <Pressable style={styles.navLink} onPress={() => handleLink('carreras')}>
                <Text style={styles.idx}>[03]</Text>
                <Text style={styles.navText}>Carreras</Text>
                <ArrowRight size={16} color={UnefaColors.gold} strokeWidth={2.5} />
              </Pressable>

              <Pressable style={styles.navLink} onPress={() => handleLink('admisiones')}>
                <Text style={styles.idx}>[04]</Text>
                <Text style={styles.navText}>Admisiones CINU</Text>
                <ArrowRight size={16} color={UnefaColors.gold} strokeWidth={2.5} />
              </Pressable>

              <Pressable style={styles.navLink} onPress={() => handleLink('servicios')}>
                <Text style={styles.idx}>[05]</Text>
                <Text style={styles.navText}>Servicios</Text>
                <ArrowRight size={16} color={UnefaColors.gold} strokeWidth={2.5} />
              </Pressable>
            </View>

            <View style={styles.featureCard}>
              <Text style={styles.featureKicker}>[+] Institución</Text>
              <Text style={styles.featureDesc}>
                Formación politécnica, investigación aplicada y doctrina cívico-militar al servicio de la República.
              </Text>
              <View style={styles.featureStats}>
                <View style={styles.statBox}>
                  <Text style={styles.statNum}>100%</Text>
                  <Text style={styles.statLabel}>Gratuidad</Text>
                </View>
                <View style={styles.statBox}>
                  <Text style={styles.statNum}>24</Text>
                  <Text style={styles.statLabel}>Estados</Text>
                </View>
              </View>
            </View>

            <View style={styles.actions}>
              <Pressable
                style={[styles.btn, styles.btnGold]}
                onPress={() => {
                  onClose();
                  router.push('/registro');
                }}>
                <Text style={styles.btnGoldText}>Preinscripción CINU</Text>
              </Pressable>
              <Pressable
                style={[styles.btn, styles.btnOutline]}
                onPress={() => {
                  onClose();
                  router.push('/login');
                }}>
                <Text style={styles.btnOutlineText}>Portal SICEU</Text>
              </Pressable>
            </View>

            <Text style={styles.footText}>
              Periodo académico 2026-I · Presencia en los 24 estados{'\n'}República Bolivariana de Venezuela
            </Text>
          </ScrollView>
        </View>
      </View>
    </Modal>
  );
}

const styles = StyleSheet.create({
  backdrop: {
    flex: 1,
    backgroundColor: 'rgba(6, 21, 42, 0.65)',
    flexDirection: 'row',
  },
  dismissOverlay: {
    width: '15%',
    height: '100%',
  },
  sheet: {
    width: '85%',
    height: '100%',
    paddingTop: 16,
    paddingHorizontal: 20,
    paddingBottom: 24,
    backgroundColor: '#ffffff',
  },
  header: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    paddingBottom: 16,
    borderBottomWidth: StyleSheet.hairlineWidth,
    borderBottomColor: '#cbd5e1',
  },
  brand: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 10,
  },
  logoWrap: {
    width: 34,
    height: 34,
    borderRadius: 8,
    backgroundColor: '#fff',
    borderWidth: 1,
    borderColor: '#e2e8f0',
    alignItems: 'center',
    justifyContent: 'center',
  },
  logo: {
    width: 28,
    height: 28,
  },
  brandName: {
    fontSize: 16,
    fontWeight: '900',
    color: '#0a0a0a',
  },
  brandSub: {
    fontSize: 10,
    color: '#64748b',
    fontWeight: '600',
  },
  closeBtn: {
    width: 32,
    height: 32,
    borderRadius: 16,
    alignItems: 'center',
    justifyContent: 'center',
    backgroundColor: '#f1f5f9',
  },
  closeText: {
    fontSize: 15,
    fontWeight: '700',
    color: '#0f172a',
  },
  content: {
    flex: 1,
    marginTop: 16,
  },
  navLinks: {
    gap: 6,
    marginBottom: 20,
  },
  navLink: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingVertical: 12,
    borderBottomWidth: StyleSheet.hairlineWidth,
    borderBottomColor: 'rgba(148, 163, 184, 0.2)',
  },
  idx: {
    fontSize: 12,
    fontFamily: 'monospace',
    color: UnefaColors.blue,
    fontWeight: '700',
    width: 38,
  },
  navText: {
    flex: 1,
    fontSize: 16,
    fontWeight: '700',
    color: '#0a0a0a',
  },
  arrow: {
    fontSize: 16,
    color: UnefaColors.gold,
    fontWeight: '800',
  },
  featureCard: {
    padding: 16,
    borderRadius: 16,
    marginBottom: 20,
    backgroundColor: '#f8fafc',
    borderWidth: 1,
    borderColor: '#e2e8f0',
  },
  featureKicker: {
    fontSize: 11,
    fontWeight: '800',
    color: UnefaColors.blue,
    textTransform: 'uppercase',
    marginBottom: 6,
  },
  featureDesc: {
    fontSize: 12,
    lineHeight: 18,
    marginBottom: 12,
    color: '#475569',
  },
  featureStats: {
    flexDirection: 'row',
    gap: 16,
  },
  statBox: {
    flex: 1,
    backgroundColor: 'rgba(255, 255, 255, 0.15)',
    padding: 8,
    borderRadius: 10,
    alignItems: 'center',
  },
  statNum: {
    fontSize: 16,
    fontWeight: '900',
    color: '#0a0a0a',
  },
  statLabel: {
    fontSize: 10,
    color: '#64748b',
    fontWeight: '600',
  },
  actions: {
    gap: 10,
    marginBottom: 20,
  },
  btn: {
    paddingVertical: 13,
    borderRadius: 14,
    alignItems: 'center',
    justifyContent: 'center',
  },
  btnGold: {
    backgroundColor: UnefaColors.gold,
  },
  btnGoldText: {
    color: UnefaColors.navy,
    fontWeight: '800',
    fontSize: 14,
  },
  btnOutline: {
    borderWidth: 1,
    borderColor: '#cbd5e1',
    backgroundColor: 'transparent',
  },
  btnOutlineText: {
    fontWeight: '700',
    fontSize: 14,
    color: '#0a0a0a',
  },
  footText: {
    fontSize: 10,
    color: '#64748b',
    textAlign: 'center',
    lineHeight: 15,
    marginBottom: 24,
  },
});
