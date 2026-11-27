import React, { useState } from 'react';
import { View, Text, Pressable, StyleSheet } from 'react-native';
import {
  Camera,
  Image as ImageIcon,
  Upload,
  CheckCircle2,
  RotateCw,
  Info,
  Sparkles,
  User,
} from 'lucide-react-native';
import { UnefaColors } from '@/constants/theme';
import { RoleConfig } from './types';

interface CarnetFotoViewProps {
  config: RoleConfig;
}

type PhotoSource = 'none' | 'camera' | 'gallery' | 'file';

export function CarnetFotoView({ config }: CarnetFotoViewProps) {
  const [photoSource, setPhotoSource] = useState<PhotoSource>('none');
  const [rotation, setRotation] = useState(0);
  const [savedSuccess, setSavedSuccess] = useState(false);
  const [photoStatus, setPhotoStatus] = useState<'pending' | 'loaded'>('pending');

  const handleSelectSource = (source: PhotoSource) => {
    setPhotoSource(source);
    setPhotoStatus('loaded');
    setSavedSuccess(false);
  };

  const handleRotate = () => {
    setRotation((prev) => (prev + 90) % 360);
  };

  const handleReset = () => {
    setPhotoSource('none');
    setRotation(0);
    setPhotoStatus('pending');
    setSavedSuccess(false);
  };

  const handleSave = () => {
    if (photoStatus === 'loaded') {
      setSavedSuccess(true);
    }
  };

  return (
    <View className="gap-5">
      {/* Encabezado */}
      <View className="bg-white rounded-[18px] p-4 border border-slate-200">
        <View className="flex-row items-center gap-2 mb-1">
          <Sparkles size={16} color={UnefaColors.goldDark} />
          <Text
            className="text-[10px] font-black tracking-widest uppercase"
            style={{ color: UnefaColors.blue }}>
            FOTOGRAFÍA INSTITUCIONAL
          </Text>
        </View>
        <Text className="text-lg font-black text-slate-900 mb-1">
          Carga de Foto para Carnet
        </Text>
        <Text className="text-xs text-slate-500 leading-relaxed">
          Opciones oficiales para capturar o adjuntar la fotografía digital de su carnet UNEFA
          en proporción obligatoria 3:4.
        </Text>
      </View>

      {/* Notificación de éxito si fue guardada */}
      {savedSuccess && (
        <View className="flex-row items-center gap-3 bg-emerald-50 border border-emerald-300 rounded-2xl p-4">
          <CheckCircle2 size={22} color="#059669" />
          <View className="flex-1">
            <Text className="text-[13px] font-black text-emerald-900">
              ¡Fotografía consignada con éxito!
            </Text>
            <Text className="text-[11px] text-emerald-700">
              La imagen cumple la proporción 3:4 y ha sido vinculada a su carnet digital 2026-I.
            </Text>
          </View>
        </View>
      )}

      {/* Estudio de foto con marco oficial 3:4 */}
      <View className="bg-white rounded-[18px] p-5 border border-slate-200 items-center">
        <View className="flex-row justify-between w-full items-center mb-3">
          <Text className="text-xs font-black uppercase text-slate-600">
            Marco Reglamentario (3:4)
          </Text>
          <View
            className="px-2.5 py-0.5 rounded-full"
            style={{
              backgroundColor:
                photoStatus === 'loaded'
                  ? 'rgba(5, 150, 105, 0.12)'
                  : 'rgba(217, 119, 6, 0.12)',
            }}>
            <Text
              className="text-[10px] font-black"
              style={{ color: photoStatus === 'loaded' ? '#059669' : '#d97706' }}>
              {photoStatus === 'loaded' ? 'FOTO CARGADA' : 'PENDIENTE POR AGREGAR'}
            </Text>
          </View>
        </View>

        {/* Contenedor con aspecto 3:4 */}
        <View
          style={[
            styles.photoFrame,
            { transform: [{ rotate: `${rotation}deg` }] },
          ]}>
          {photoStatus === 'loaded' ? (
            <View className="w-full h-full items-center justify-center bg-slate-800 p-2">
              <View className="w-24 h-24 rounded-full bg-blue-100 items-center justify-center mb-2 border-2 border-amber-400">
                <User size={52} color={UnefaColors.navy} />
              </View>
              <Text className="text-xs font-black text-white text-center">
                {config.name}
              </Text>
              <Text className="text-[10px] font-bold text-amber-400 text-center">
                {config.cedula}
              </Text>
              <View className="mt-2 px-2 py-0.5 rounded bg-emerald-600/80">
                <Text className="text-[9px] font-black text-white uppercase">
                  {photoSource === 'camera'
                    ? 'Captura de Cámara'
                    : photoSource === 'gallery'
                    ? 'Imagen de Galería'
                    : 'Archivo Adjuntado'}
                </Text>
              </View>
            </View>
          ) : (
            <View className="w-full h-full items-center justify-center bg-slate-100 p-4">
              <View className="w-20 h-20 rounded-full bg-slate-200 items-center justify-center mb-3">
                <User size={44} color="#94a3b8" />
              </View>
              <Text className="text-xs font-black text-slate-600 text-center">
                Sin foto asignada
              </Text>
              <Text className="text-[10px] text-slate-400 text-center mt-1 leading-4">
                Seleccione una opción debajo para agregar la foto
              </Text>
            </View>
          )}

          {/* Guías de composición (regla de los tercios) */}
          <View pointerEvents="none" style={styles.gridOverlay}>
            <View style={styles.gridRow}>
              <View style={[styles.gridCell, styles.borderRight, styles.borderBottom]} />
              <View style={[styles.gridCell, styles.borderRight, styles.borderBottom]} />
              <View style={[styles.gridCell, styles.borderBottom]} />
            </View>
            <View style={styles.gridRow}>
              <View style={[styles.gridCell, styles.borderRight, styles.borderBottom]} />
              <View style={[styles.gridCell, styles.borderRight, styles.borderBottom]} />
              <View style={[styles.gridCell, styles.borderBottom]} />
            </View>
            <View style={styles.gridRow}>
              <View style={[styles.gridCell, styles.borderRight]} />
              <View style={[styles.gridCell, styles.borderRight]} />
              <View style={styles.gridCell} />
            </View>
          </View>
        </View>

        {/* Metadatos y controles de ajuste */}
        <View className="w-full mt-3 flex-row items-center justify-between pt-2 border-t border-slate-100">
          <Text className="text-[11px] font-mono font-bold text-slate-500">
            Proporción: 3:4 (mín. 600×800)
          </Text>
          {photoStatus === 'loaded' && (
            <View className="flex-row gap-2">
              <Pressable
                onPress={handleRotate}
                accessibilityRole="button"
                accessibilityLabel="Rotar foto 90 grados"
                className="flex-row items-center gap-1 px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-300 active:bg-slate-200">
                <RotateCw size={12} color="#334155" />
                <Text className="text-[11px] font-bold text-slate-700">Rotar</Text>
              </Pressable>
              <Pressable
                onPress={handleReset}
                accessibilityRole="button"
                accessibilityLabel="Quitar foto"
                className="px-2.5 py-1 rounded-lg bg-slate-100 border border-slate-300 active:bg-slate-200">
                <Text className="text-[11px] font-bold text-rose-600">Restablecer</Text>
              </Pressable>
            </View>
          )}
        </View>
      </View>

      {/* Opciones interactivas para agregar la foto */}
      <View className="bg-white rounded-[18px] p-4 border border-slate-200">
        <Text className="text-[10px] font-black tracking-widest uppercase mb-1 text-slate-500">
          MÉTODOS DE CAPTURA DISPONIBLES
        </Text>
        <Text className="text-base font-black text-slate-900 mb-3">
          Agregar Foto del Carnet
        </Text>

        <View className="gap-2.5">
          {/* Opción 1: Cámara */}
          <Pressable
            accessibilityRole="button"
            accessibilityLabel="Tomar foto con la cámara"
            onPress={() => handleSelectSource('camera')}
            className={`flex-row items-center gap-3.5 p-3.5 rounded-2xl border active:opacity-90 ${
              photoSource === 'camera'
                ? 'bg-blue-50/70 border-unefa-blue'
                : 'bg-slate-50 border-slate-200'
            }`}>
            <View
              className="w-11 h-11 rounded-xl items-center justify-center"
              style={{ backgroundColor: UnefaColors.navy }}>
              <Camera size={20} color="#ffffff" />
            </View>
            <View className="flex-1">
              <Text className="text-sm font-black text-slate-900">
                Tomar foto con la cámara
              </Text>
              <Text className="text-xs text-slate-500">
                Abre el sensor fotográfico con guía de encuadre
              </Text>
            </View>
            {photoSource === 'camera' && (
              <CheckCircle2 size={18} color={UnefaColors.blue} />
            )}
          </Pressable>

          {/* Opción 2: Galería */}
          <Pressable
            accessibilityRole="button"
            accessibilityLabel="Seleccionar de la galería"
            onPress={() => handleSelectSource('gallery')}
            className={`flex-row items-center gap-3.5 p-3.5 rounded-2xl border active:opacity-90 ${
              photoSource === 'gallery'
                ? 'bg-blue-50/70 border-unefa-blue'
                : 'bg-slate-50 border-slate-200'
            }`}>
            <View
              className="w-11 h-11 rounded-xl items-center justify-center"
              style={{ backgroundColor: UnefaColors.gold }}>
              <ImageIcon size={20} color={UnefaColors.navy} />
            </View>
            <View className="flex-1">
              <Text className="text-sm font-black text-slate-900">
                Seleccionar de la galería
              </Text>
              <Text className="text-xs text-slate-500">
                Elige una imagen almacenada en tu dispositivo
              </Text>
            </View>
            {photoSource === 'gallery' && (
              <CheckCircle2 size={18} color={UnefaColors.blue} />
            )}
          </Pressable>

          {/* Opción 3: Subir archivo */}
          <Pressable
            accessibilityRole="button"
            accessibilityLabel="Cargar archivo digital"
            onPress={() => handleSelectSource('file')}
            className={`flex-row items-center gap-3.5 p-3.5 rounded-2xl border active:opacity-90 ${
              photoSource === 'file'
                ? 'bg-blue-50/70 border-unefa-blue'
                : 'bg-slate-50 border-slate-200'
            }`}>
            <View
              className="w-11 h-11 rounded-xl items-center justify-center"
              style={{ backgroundColor: '#0d9488' }}>
              <Upload size={20} color="#ffffff" />
            </View>
            <View className="flex-1">
              <Text className="text-sm font-black text-slate-900">
                Cargar archivo digital
              </Text>
              <Text className="text-xs text-slate-500">
                Formatos compatibles: JPG, JPEG o PNG hasta 5 MB
              </Text>
            </View>
            {photoSource === 'file' && (
              <CheckCircle2 size={18} color={UnefaColors.blue} />
            )}
          </Pressable>
        </View>

        {/* Botón Guardar */}
        {photoStatus === 'loaded' && (
          <Pressable
            accessibilityRole="button"
            accessibilityLabel="Guardar foto del carnet"
            onPress={handleSave}
            className="mt-4 py-3.5 rounded-xl items-center active:opacity-90"
            style={{ backgroundColor: UnefaColors.blue }}>
            <Text className="text-sm font-black text-white">
              Guardar Foto del Carnet
            </Text>
          </Pressable>
        )}
      </View>

      {/* Normativa y requisitos oficiales */}
      <View className="bg-slate-50 rounded-[18px] p-4 border border-slate-200">
        <View className="flex-row items-center gap-2 mb-2">
          <Info size={16} color={UnefaColors.blue} />
          <Text className="text-xs font-black text-slate-800">
            Requisitos Oficiales para el Carnet
          </Text>
        </View>
        <View className="gap-1.5 pl-1">
          <Text className="text-xs text-slate-600">
            • <Text className="font-bold">Proporción 3:4:</Text> La foto debe ser vertical tipo carnet.
          </Text>
          <Text className="text-xs text-slate-600">
            • <Text className="font-bold">Fondo claro y uniforme:</Text> Preferiblemente fondo blanco.
          </Text>
          <Text className="text-xs text-slate-600">
            • <Text className="font-bold">Vista frontal:</Text> Rostro y hombros completamente descubiertos.
          </Text>
          <Text className="text-xs text-slate-600">
            • <Text className="font-bold">Sin accesorios:</Text> Prohibido el uso de gorras o lentes oscuros.
          </Text>
        </View>
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  photoFrame: {
    width: 195,
    height: 260,
    borderRadius: 16,
    overflow: 'hidden',
    borderWidth: 3,
    borderColor: UnefaColors.gold,
    position: 'relative',
    backgroundColor: '#0f172a',
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.2,
    shadowRadius: 8,
    elevation: 5,
  },
  gridOverlay: {
    ...StyleSheet.absoluteFill,
  },
  gridRow: {
    flex: 1,
    flexDirection: 'row',
  },
  gridCell: {
    flex: 1,
  },
  borderRight: {
    borderRightWidth: StyleSheet.hairlineWidth,
    borderRightColor: 'rgba(255, 255, 255, 0.25)',
  },
  borderBottom: {
    borderBottomWidth: StyleSheet.hairlineWidth,
    borderBottomColor: 'rgba(255, 255, 255, 0.25)',
  },
});
